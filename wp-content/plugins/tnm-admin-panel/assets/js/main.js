var BKADMINPANEL = BKADMINPANEL || {};

(function($){
    "use strict";

	var $window = $(window);
	var $document = $(document);
    
    BKADMINPANEL.documentOnReady = {
        
		init: function(){
            BKADMINPANEL.documentOnReady.ajaxPluginActions();
            BKADMINPANEL.documentOnReady.ajaxDemoImport();
        },
       /* ============================================================================
         * Ajax Admin Plugins
         * ==========================================================================*/
        
        ajaxPluginActions: function() {
            var $ajaxPluginActions = $('.bk-plugins-wrapper');
            var $this;
            var $ajaxReqs = [];
            var $ajaxRequesting = false;

            $ajaxPluginActions.each(function() {
                $this = $(this);
                var $triggerBtn = $this.find('a');
                $triggerBtn.on('click', function(e) {
                    e.preventDefault();
                    ajaxPush($(this));
                });
            });
            function ajaxPush(req){
                req.closest('.bk-demo-item').attr('class', 'bk-demo-item plugin-pending');
                req.siblings('.plugin-installing-pending').css('display', 'inline-block');
                $ajaxReqs.push(req);
                ajaxNext();
            }
            function ajaxNext(){
                if ($ajaxReqs.length == 0)
                  return;
                
                if ($ajaxRequesting == true)
                  return;
                  
                var req = $ajaxReqs.splice(0, 1)[0];
                var $ajaxURL = req.attr('href');
                var parameters = {
					title: req.attr('title'),
				};
                req.siblings('.plugin-installing-pending').hide();
                req.siblings('.plugin-installing').show();
                
                $ajaxRequesting = true;
                var	ajaxStatus = '',
				ajaxCall = jQuery.ajax({
                    type: "POST",
                    url: $ajaxURL,
                });
                ajaxCall.done(function() {
                    var ajaxArgs = {
                        action: 'plugin_check',
                        plugin_name: parameters.title,
                    };
                    $.post(ajaxurl, ajaxArgs, function (response) {
                        var $results = $.parseJSON(response);
                        console.log($results);
                        if($results == 'plugin-active') {
                            req.closest('.bk-demo-item').attr('class', 'bk-demo-item plugin-active');
                            req.siblings('.plugin-installing').hide();
                            if(checkAllRequiredPlugins_isActive()) {
                                var more_tabs = '<a href="admin.php?page=bk-theme-demos" class="nav-tab">Install demos</a><a href="admin.php?page=bk-system-status" class="nav-tab">System status</a><a href="admin.php?page=_options" class="nav-tab">Theme Options</a>';
                                req.parents('.page-wrap').find('.nav-tab:nth-child(2)').nextAll().remove();
                                req.parents('.page-wrap').find('.nav-tab-wrapper').append(more_tabs);
                            }
                        }else if($results == 'plugin-inactive') {
                            req.closest('.bk-demo-item').attr('class', 'bk-demo-item plugin-inactive');
                            req.siblings('.plugin-installing').hide();
                            if(checkAllRequiredPlugins_isActive() == 0) {
                                req.parents('.page-wrap').find('.nav-tab:nth-child(2)').nextAll().remove();
                            }
                        }else {
                            
                        }
                        $ajaxRequesting = false;
                        ajaxNext();
                    });
                });
                ajaxCall.fail(function() {
                    
                });
                ajaxCall.always(function() {
                    
                });
            }
            function checkAllRequiredPlugins_isActive(){
                var requiredPlugins = $('.bk-plugins-wrapper').find('.a-required-plugin');
                var statusRet = 0;
                requiredPlugins.each(function() {
                    if($(this).closest('.bk-demo-item').hasClass('plugin-active')) {
                        statusRet = 1;
                    }else {
                        statusRet = 0;
                        return false;
                    }
                });
                return statusRet;
            }
        },
        ajaxDemoImport: function() {
            var $ajaxImportActions = $('.bk_importer_start');
            var $this;
            var attachments_per_query = 1;
                                    
            $ajaxImportActions.on('click', function(e) {
                e.preventDefault();
                if($(this).hasClass('tnm-off-click')) return;
                                
                $this = $(this);
                
                $ajaxImportActions.addClass('tnm-off-click');
                
                $this.closest('.bk-demo-item-inner').siblings('.bk-import-process-bar').css('width', '1%' );
                $this.closest('.bk-demo-item-inner').removeClass('demo-waiting');
                $this.closest('.bk-demo-item-inner').addClass('demo-importing');
                $this.siblings('.plugin-installing').show();
                
                var $thisDemo = $this.closest('.bk-demo-item').attr('class').split(' ').pop();
                var $ImportAttachment = $this.closest('.bk-demo-item-inner').find('input[type="checkbox"]');

                if ($ImportAttachment.is(":checked")){
                    $.ajax({
        				type: "POST",
        				url: ajaxurl,
        				data: {
        					action          : 'bk_demo_import_start',
                            import_source   : import_source[$thisDemo],
                            demoType        : $thisDemo,
        				},
        				dataType: 'json'
        			}).success(function(data){
        			 console.log(data);
        				if(data.attachments) {
        					var start_from=parseInt(data['last_attachment_index']) + 1;
        					import_process(data, start_from);
        				}        				
        			});
                }else {
                    import_others();
                }
            });
            function import_process(data, start_from) {
                console.log(start_from);
                console.log(data.attachments.length);
                if(start_from < data.attachments.length) {
                    
        			var w=start_from > 0 ? start_from / data.attachments.length : 0;
        			w*=95;
        			$this.closest('.bk-demo-item-inner').siblings('.bk-import-process-bar').css('width', w + '%' );
        			
                    var $thisDemo = $this.closest('.bk-demo-item').attr('class').split(' ').pop();
        			var last=start_from + attachments_per_query;
        			if(last > data.attachments.length)
        				last=data.attachments.length;
        			var	attachments=data.attachments.slice(start_from, last);
                    
                    console.log(attachments);
                    
        			if(attachments.length) {
        				
        				$.ajax({
        					type: "POST",
        					url: ajaxurl,
        					data: {
        						action          : 'bk_demo_import_attachments',
        						import_source   : import_source[$thisDemo],
                                demoType        : $thisDemo,
        						data: {
        							common: data.common,
        							attachments: attachments,
        							first_attachment_index: start_from
        						}
        					},
        					dataType: 'json'
        				}).success(function(dataRet){
        				    console.log(dataRet);
        					import_process(data, start_from + attachments_per_query);
        				});
        				
        			}
        			
        		}else {
                    import_others();
        		}
            }
            
            function import_others() {
                var $thisDemo = $this.closest('.bk-demo-item').attr('class').split(' ').pop();
                $.ajax({
        			type: "POST",
        			url: ajaxurl,
        			data: {
        				action          : 'bk_demo_import_others',
                        import_source   : import_source[$thisDemo],
                        demoType        : $thisDemo,
        			},
        			dataType: 'json'
        		}).success(function(data){
        		  console.log(data);
                    if(data.error == 0) {
        				$this.closest('.bk-demo-item-inner').siblings('.bk-import-process-bar').css('width', '100%' );
                        $this.closest('.bk-demo-item-inner').removeClass('demo-importing');
                        $this.closest('.bk-demo-item-inner').addClass('demo-done');         
                        $ajaxImportActions.removeClass('tnm-off-click');               
        			}
        		});
            }
        },
    }
    $document.ready( BKADMINPANEL.documentOnReady.init );
})(jQuery);