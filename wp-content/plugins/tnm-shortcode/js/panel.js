(function() {
    tinymce.PluginManager.add('bk_shortcode_button', function( editor, url ) {
        editor.addButton( 'bk_shortcode_button', {
            title: 'Shortcodes',
            type: 'menubutton',
            icon: false,
            text: 'Shortcodes',
            menu: [
                {
                    text: 'Image',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Image',
                            classes: 'bk-shortcode-popup-frame',
                            body: [
                            {
                                type: 'textbox',
                                name: 'image',
                                label: 'Image',
                                value: '',
                                classes: 'my_input_image',
                            },
                            {
                                type: 'button',
                                name: 'my_upload_button',
                                label: ' ',
                                text: 'Upload image',
                                classes: 'my_upload_button',
                            },
                            {
                                type: 'textbox',
                                multiline : true,
                                minHeight: 150,
                                name: 'img_caption',
                                label: 'Caption',
                                value: '',
                                classes: '',
                            },
                            {
                                type: 'listbox',
                                name: 'lightbox',
                                label: 'Lightbox iFrame',
                                values: [{text: 'Enable', value: 1}, {text: 'Disable', value: 0}]
                            },
                            ],
                            onsubmit: function( e ) {
                                editor.insertContent( 
                                    '<p>[image lightbox="' + e.data.lightbox + '" caption="' + e.data.img_caption + '"]'
                                         + e.data.image +
                                    '[/image]</p>');
                            }
                        });
                    }
                },
                {
                    text: 'Blockquote',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Blockquote',
                            classes: 'bk-shortcode-popup-frame',
                            body: [
                            {
                                type: 'textbox',
                                multiline : true,
                                minHeight: 150,
                                name: 'content',
                                label: 'Blockquote Content',
                            },
                            {
                                type: 'textbox',
                                multiline : true,
                                minHeight: 150,
                                name: 'footer',
                                label: 'Blockquote Footer',
                            },
                            ],
                            onsubmit: function( e ) {
                                editor.insertContent( 
                                    '<p>[blockquote footer="' + e.data.footer + '"]' +
                                    e.data.content +
                                    '[/blockquote]</p>');
                            }
                        });
                    }
                },
                {
                    text: 'Button',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Button',
                            classes: 'bk-shortcode-popup-frame',
                            body: [
                            {
                                type: 'textbox',
                                name: 'content',
                                label: 'Button Text',
                            },
                            {
                                type: 'textbox',
                                name: 'href',
                                label: 'Button Link',
                            },
                            {
                                type: 'listbox',
                                name: 'type',
                                label: 'Type',
                                values: [{text: 'Default', value: 'btn-default'}, {text: 'Primary', value: 'btn-primary'}, {text: 'Success', value: 'btn-success'}, {text: 'Info', value: 'btn-info'}, {text: 'Warning', value: 'btn-warning'}, {text: 'Danger', value: 'btn-danger'}, {text: 'Link', value: 'btn-link'}]
                            },
                            {
                                type: 'listbox',
                                name: 'size',
                                label: 'Size',
                                values: [{text: 'Large', value: 'btn-lg'}, {text: 'Medium', value: 'btn-md'}, {text: 'Small', value: 'btn-sm'}, {text: 'Extra Small', value: 'btn-xs'}]
                            },
                            ],
                            onsubmit: function( e ) {
                                editor.insertContent( 
                                    '[button href="' + e.data.href + '" type="' + e.data.type + '" size="' + e.data.size + '"]'
                                         + e.data.content +
                                    '[/button]');
                            }
                        });
                    }
                },
                {
                    text:'Columns',
                    menu:[{
                            text: '1/2 1/2',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: '1/2 1/2',
                                    classes: 'bk-shortcode-popup-frame',
                                    body: [
                                    {
                                        type: 'textbox',
                                        name: 'first_content',
                                        multiline : true,
                                        minHeight: 150,
                                        label: 'First Column Content (1/3)'
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'second_content',
                                        multiline : true,
                                        minHeight: 150,
                                        label: 'Second Column Content (1/3)'
                                    },
                                    ],
                                    onsubmit: function( e ) {
                                        editor.insertContent( 
                                            '<p>[one_halfs]</p>' + 
                                                '<p>[one_half]' + e.data.first_content + '[/one_half]</p>' + 
                                                '<p>[one_half]' + e.data.second_content + '[/one_half]</p>' + 
                                            '<p>[/one_halfs]</p>');
                                    }
                                });
                            }
                        },
                        {
                            text: '1/3 1/3 1/3 Column',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: '1/3 1/3 1/3 Column',
                                    classes: 'bk-shortcode-popup-frame',
                                    body: [
                                    {
                                        type: 'textbox',
                                        name: 'first_content',
                                        multiline : true,
                                        minHeight: 150,
                                        label: 'First Column Content (1/3)'
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'second_content',
                                        multiline : true,
                                        minHeight: 150,
                                        label: 'Second Column Content (1/3)'
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'third_content',
                                        multiline : true,
                                        minHeight: 150,
                                        label: 'Third Column Content (1/3)'
                                    },
                                    ],
                                    onsubmit: function( e ) {
                                        editor.insertContent( 
                                            '<p>[one_thirds]</p>' + 
                                                '<p>[one_third]' + e.data.first_content + '[/one_third]</p>' + 
                                                '<p>[one_third]' + e.data.second_content + '[/one_third]</p>' + 
                                                '<p>[one_third]' + e.data.third_content + '[/one_third]</p>' + 
                                            '<p>[/one_thirds]</p>');
                                    }
                                });
                            }
                        },
                        {
                            text: '2/3 1/3 Column',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: '2/3 1/3 Column',
                                    classes: 'bk-shortcode-popup-frame',
                                    body: [
                                    {
                                        type: 'textbox',
                                        name: 'first_content',
                                        multiline : true,
                                        minHeight: 150,
                                        label: 'First Column Content (2/3)'
                                    },
                                    {
                                        type: 'textbox',
                                        name: 'second_content',
                                        multiline : true,
                                        minHeight: 150,
                                        label: 'Second Column Content (1/3)'
                                    },
                                    ],
                                    onsubmit: function( e ) {
                                        editor.insertContent( 
                                            '<p>[twothird_onethird]</p>' + 
                                                '<p>[two_third]' + e.data.first_content + '[/two_third]</p>' + 
                                                '<p>[one_third]' + e.data.second_content + '[/one_third]</p>' + 
                                            '<p>[/twothird_onethird]</p>');
                                    }
                                });
                            }
                        },
                    ],
                }, 
                {
                    text: 'Tabs ',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Tabs ',
                            classes: 'bk-shortcode-popup-frame',
                            body: [
                            {
                                type: 'textbox',
                                name: 'tab1',
                                label: 'Tab Title 1'
                            },
                            {
                                type: 'textbox',
                                name: 'tab1_content',
                                multiline : true,
                                minHeight: 150,
                                label: 'Tab Content 1'
                            },
                            {
                                type: 'textbox',
                                name: 'tab2',
                                label: 'Tab Title 2'
                            },
                            {
                                type: 'textbox',
                                name: 'tab2_content',
                                multiline : true,
                                minHeight: 150,
                                label: 'Tab Content 2'
                            },
                            {
                                type: 'textbox',
                                name: 'tab3',
                                label: 'Tab Title 3'
                            },
                            {
                                type: 'textbox',
                                name: 'tab3_content',
                                multiline : true,
                                minHeight: 150,
                                label: 'Tab Content 3'
                            },
                            {
                                type: 'textbox',
                                name: 'tab4',
                                label: 'Tab Title 4'
                            },
                            {
                                type: 'textbox',
                                name: 'tab4_content',
                                multiline : true,
                                minHeight: 150,
                                label: 'Tab Content4'
                            },
                            {
                                type: 'textbox',
                                name: 'tab5',
                                label: 'Tab Title 5'
                            },
                            {
                                type: 'textbox',
                                name: 'tab5_content',
                                multiline : true,
                                minHeight: 150,
                                label: 'Tab Content 5'
                            },
                            ],
                            onsubmit: function( e ) {
                                var tab1SC = '', tab2SC = '', tab3SC = '', tab4SC = '', tab5SC = '';
                                if(e.data.tab1 != '') {
                                    tab1SC = '<p>[tab title=' + e.data.tab1 + ']' + e.data.tab1_content + '[/tab]</p>';
                                }
                                if(e.data.tab2 != '') {
                                    tab2SC = '<p>[tab title=' + e.data.tab2 + ']' + e.data.tab2_content + '[/tab]</p>';
                                }
                                if(e.data.tab3 != '') {
                                    tab3SC = '<p>[tab title=' + e.data.tab3 + ']' + e.data.tab3_content + '[/tab]</p>';
                                }
                                if(e.data.tab4 != '') {
                                    tab4SC = '<p>[tab title=' + e.data.tab4 + ']' + e.data.tab4_content + '[/tab]</p>';
                                }
                                if(e.data.tab5 != '') {
                                    tab5SC = '<p>[tab title=' + e.data.tab5 + ']' + e.data.tab5_content + '[/tab]</p>';
                                }
                                editor.insertContent( 
                                    '<p>[tabs]</p>' + 
                                        tab1SC + tab2SC + tab3SC + tab4SC + tab5SC +
                                    '<p>[/tabs]</p>');
                            }
                        });
                    }
                },
                {
                    text: 'Gallery',
                    menu:[
                        {
                            text: 'Gallery 1',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Gallery 1',
                                    classes: 'bk-shortcode-popup-frame',
                                    body: [
                                    {
                                        type: 'textbox',
                                        name: 'galleryImgIds',
                                        multiline : true,
                                        minHeight: 50,
                                        label: 'Image IDs (Ex: 1,2,3,4)'
                                    },
                                    {
                                        type: 'listbox',
                                        name: 'layout',
                                        label: 'Lay out',
                                        values: [{text: 'Wide', value: 'mnmd-post-media-wide'}, {text: 'Normal', value: 'mnmd-post-media'}]
                                    },
                                    ],
                                    onsubmit: function( e ) {
                                        editor.insertContent( 
                                            '<p>[tnm_gallery_1 layout="'+e.data.layout+'"]' + e.data.galleryImgIds + '[/tnm_gallery_1]</p>'
                                        );
                                    }
                                });
                            }
                        },
                        {
                            text: 'Gallery 2',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Gallery 2',
                                    classes: 'bk-shortcode-popup-frame',
                                    body: [
                                    {
                                        type: 'textbox',
                                        name: 'galleryImgIds',
                                        multiline : true,
                                        minHeight: 50,
                                        label: 'Image IDs (Separated by a comma (,)'
                                    },
                                    {
                                        type: 'listbox',
                                        name: 'layout',
                                        label: 'Lay out',
                                        values: [{text: 'Wide', value: 'mnmd-post-media-wide'}, {text: 'Normal', value: 'mnmd-post-media'}]
                                    },
                                    ],
                                    onsubmit: function( e ) {
                                        editor.insertContent( 
                                            '<p>[tnm_gallery_2 layout="'+e.data.layout+'"]' + e.data.galleryImgIds + '[/tnm_gallery_2]</p>'
                                        );
                                    }
                                });
                            }
                        },
                        {
                            text: 'Gallery 3',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Gallery 3',
                                    classes: 'bk-shortcode-popup-frame',
                                    body: [
                                    {
                                        type: 'textbox',
                                        name: 'galleryImgIds',
                                        multiline : true,
                                        minHeight: 50,
                                        label: 'Image IDs (Separated by a comma (,)'
                                    },
                                    {
                                        type: 'listbox',
                                        name: 'layout',
                                        label: 'Lay out',
                                        values: [{text: 'Wide', value: 'mnmd-post-media-wide'}, {text: 'Normal', value: 'mnmd-post-media'}]
                                    },
                                    ],
                                    onsubmit: function( e ) {
                                        editor.insertContent( 
                                            '<p>[tnm_gallery_3 layout="'+e.data.layout+'"]' + e.data.galleryImgIds + '[/tnm_gallery_3]</p>'
                                        );
                                    }
                                });
                            }
                        },
                        {
                            text: 'Gallery 4',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'Gallery 4',
                                    classes: 'bk-shortcode-popup-frame',
                                    body: [
                                    {
                                        type: 'textbox',
                                        name: 'galleryImgIds',
                                        multiline : true,
                                        minHeight: 50,
                                        label: 'Image IDs (Separated by a comma (,)'
                                    },
                                    {
                                        type: 'listbox',
                                        name: 'layout',
                                        label: 'Lay out',
                                        values: [{text: 'Wide', value: 'mnmd-post-media-wide'}, {text: 'Normal', value: 'mnmd-post-media'}]
                                    },
                                    {
                                        type: 'listbox',
                                        name: 'columns',
                                        label: 'Columns',
                                        values: [
                                                    {text: '1', value: 'gallery-columns-1'}, 
                                                    {text: '2', value: 'gallery-columns-2'}, 
                                                    {text: '3', value: 'gallery-columns-3'}, 
                                                    {text: '4', value: 'gallery-columns-4'}, 
                                                    {text: '5', value: 'gallery-columns-5'}, 
                                                    {text: '6', value: 'gallery-columns-6'}, 
                                                    {text: '7', value: 'gallery-columns-7'}, 
                                                    {text: '8', value: 'gallery-columns-8'}, 
                                                    {text: '9', value: 'gallery-columns-9'}, 
                                                ]
                                    },
                                    ],
                                    onsubmit: function( e ) {
                                        editor.insertContent( 
                                            '<p>[tnm_gallery_4 layout="'+e.data.layout+'" columns="'+e.data.columns+'"]' + e.data.galleryImgIds + '[/tnm_gallery_4]</p>'
                                        );
                                    }
                                });
                            }
                        },
                    ]
                },
                {
                    text: 'Accordion ',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Accordion ',
                            classes: 'bk-shortcode-popup-frame',
                            body: [
                            {
                                type: 'textbox',
                                name: 'accordion1',
                                label: 'Accordion Title 1'
                            },
                            {
                                type: 'textbox',
                                name: 'accordion1_content',
                                multiline : true,
                                minHeight: 150,
                                label: 'Accordion Content 1'
                            },
                            {
                                type: 'textbox',
                                name: 'accordion2',
                                label: 'Accordion Title 2'
                            },
                            {
                                type: 'textbox',
                                name: 'accordion2_content',
                                multiline : true,
                                minHeight: 150,
                                label: 'Accordion Content 2'
                            },
                            {
                                type: 'textbox',
                                name: 'accordion3',
                                label: 'Accordion Title 3'
                            },
                            {
                                type: 'textbox',
                                name: 'accordion3_content',
                                multiline : true,
                                minHeight: 150,
                                label: 'Accordion Content 3'
                            },
                            {
                                type: 'textbox',
                                name: 'accordion4',
                                label: 'Accordion Title 4'
                            },
                            {
                                type: 'textbox',
                                name: 'accordion4_content',
                                multiline : true,
                                minHeight: 150,
                                label: 'Accordion Content 4'
                            },
                            {
                                type: 'textbox',
                                name: 'accordion5',
                                label: 'Accordion Title 5'
                            },
                            {
                                type: 'textbox',
                                name: 'accordion5_content',
                                multiline : true,
                                minHeight: 150,
                                label: 'Accordion Content 5'
                            },
                            ],
                            onsubmit: function( e ) {
                                var A1SC = '', A2SC = '', A3SC = '', A4SC = '', A5SC = '';
                                if(e.data.accordion1 != '') {
                                    A1SC = '<p>[accordion title=' + e.data.accordion1 + ']' + e.data.accordion1_content + '[/accordion]</p>';
                                }
                                if(e.data.accordion2 != '') {
                                    A2SC = '<p>[accordion title=' + e.data.accordion2 + ']' + e.data.accordion2_content + '[/accordion]</p>';
                                }
                                if(e.data.accordion3 != '') {
                                    A3SC = '<p>[accordion title=' + e.data.accordion3 + ']' + e.data.accordion3_content + '[/accordion]</p>';
                                }
                                if(e.data.accordion4 != '') {
                                    A4SC = '<p>[accordion title=' + e.data.accordion4 + ']' + e.data.accordion4_content + '[/accordion]</p>';
                                }
                                if(e.data.accordion5 != '') {
                                    A5SC = '<p>[accordion title=' + e.data.accordion5 + ']' + e.data.accordion5_content + '[/accordion]</p>';
                                }
                                editor.insertContent( 
                                    '<p>[accordions]</p>' + 
                                         A1SC + A2SC + A3SC + A4SC + A5SC + 
                                    '<p>[/accordions]</p>');
                            }
                        });
                    }
                },
                
                {
                    text: 'Author Box',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Author Box',
                            classes: 'bk-shortcode-popup-frame',
                            body: [
                            {
                                type: 'textbox',
                                name: 'authorid',
                                label: 'Author ID'
                            },
                            ],
                            onsubmit: function( e ) {
                                editor.insertContent( 
                                    '<p>[authorbox]' + e.data.authorid + '[/authorbox]</p>');
                            }
                        });
                    }
                },
                
                {
                    text: 'Video',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Video Link (Youtube, Vimeo)',
                            classes: 'bk-shortcode-popup-frame',
                            body: [
                            {
                                type: 'textbox',
                                name: 'videoLink',
                                multiline : true,
                                minHeight: 100,
                                label: 'Video Link'
                            },
                            {
                                type: 'listbox',
                                name: 'layout',
                                label: 'Lay out',
                                values: [{text: 'Wide', value: 'mnmd-post-media-wide'}, {text: 'Normal', value: 'mnmd-post-media'}]
                            },
                            
                            ],
                            onsubmit: function( e ) {
                                editor.insertContent( '<p>[tnm_video layout="'+e.data.layout+'"]' + e.data.videoLink + '[/tnm_video]</p>');
                            }
                        });
                    }
                },
           ]
        });
    });
})();
jQuery(document).ready(function($){
    $(document).on('click', '.mce-my_upload_button', upload_image_tinymce);

    function upload_image_tinymce(e) {
        e.preventDefault();
        var $input_field = $('.mce-my_input_image');
        var custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Add Image',
            button: {
                text: 'Add Image'
            },
            multiple: false
        });
        custom_uploader.on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            console.log(attachment);
            $input_field.val(attachment.url);
        });
        custom_uploader.open();
    }
});