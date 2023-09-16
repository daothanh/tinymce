<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="{ state: $wire.$entangle('{{ $getStatePath() }}'), initialized: false }"
        x-init="(() => {
            $nextTick(() => {
                tinymce.createEditor('tiny-editor-{{ $getId() }}', {
                    target: $refs.tinymce,
                    language: '{{ $getLanguage() }}',
                    setup: function(editor) {
                        if(!window.tinySettingsCopy) {
                            window.tinySettingsCopy = [];
                        }
                        window.tinySettingsCopy.push(editor.settings);

                        editor.on('blur', function(e) {
                            state = editor.getContent()
                        })

                        editor.on('init', function(e) {
                            if (state != null) {
                                editor.setContent(state)
                            }
                        })

                        editor.on('OpenWindow', function(e) {
                            target = e.target.container.closest('.filament-modal')
                            if (target) target.setAttribute('x-trap.noscroll', 'false')
                        })

                        editor.on('CloseWindow', function(e) {
                            target = e.target.container.closest('.filament-modal')
                            if (target) target.setAttribute('x-trap.noscroll', 'isOpen')
                        })

                        function putCursorToEnd() {
                            editor.selection.select(editor.getBody(), true);
                            editor.selection.collapse(false);
                        }

                        $watch('state', function(newstate) {
                            // unfortunately livewire doesn't provide a way to 'unwatch' so this listener sticks
                            // around even after this component is torn down. Which means that we need to check
                            // that editor.container exists. If it doesn't exist we do nothing because that means
                            // the editor was removed from the DOM
                            if (editor.container && newstate !== editor.getContent()) {
                                editor.resetContent(newstate || '');
                                putCursorToEnd();
                            }
                        });
                    },
                    menubar: {{ $getShowMenuBar() ? 'true' : 'false' }},
                    plugins: '{{ $getPlugins() }}',
                    toolbar: '{{ $getToolbar() }}',
                    toolbar_sticky: {{ $getToolbarSticky() ? 'true' : 'false' }},
                    toolbar_sticky_offset: 64,
                    toolbar_mode: 'sliding',
                    branding: false,
                    relative_urls: {{ $getRelativeUrls() ? 'true' : 'false' }},
                    remove_script_host: {{ $getRemoveScriptHost() ? 'true' : 'false' }},
                    convert_urls: {{ $getConvertUrls() ? 'true' : 'false' }},
                    images_upload_handler: (blobInfo, success, failure, progress) => {
                        if (!blobInfo.blob()) return

                        $wire.upload(`componentFileAttachments.{{ $getStatePath() }}`, blobInfo.blob(), () => {
                            $wire.getFormComponentFileAttachmentUrl('{{ $getStatePath() }}').then((url) => {
                                if (!url) {
                                    failure('{{ __('Error uploading file') }}')
                                    return
                                }
                                success(url)
                            })
                        })
                    },
                    automatic_uploads: true,
                    skin: {
                        light: 'oxide',
                        dark: 'oxide-dark',
                        system: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'oxide-dark' : 'oxide',
                    }[typeof theme === 'undefined' ? 'light' : theme],
                    file_picker_callback : function(callback, value, meta) {
                        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                        var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
                        var cmsURL = '/{{ $getFileManagerPath() }}?editor=' + meta.fieldname;
                        if (meta.filetype == 'image') {
                            cmsURL = cmsURL + '&type=Images';
                        } else {
                            cmsURL = cmsURL + '&type=Files';
                        }
                        tinyMCE.activeEditor.windowManager.openUrl({
                          url : cmsURL,
                          title : 'Filemanager',
                          width : x * 0.8,
                          height : y * 0.8,
                          resizable : 'yes',
                          close_previous : 'no',
                          onMessage: (api, message) => {
                            callback(message.content);
                          }
                        });
                        //alert(cmsURL);
                    }
                }).render();
            });
            if (!window.tinyMceInitialized) {
                window.tinyMceInitialized = true;
                $nextTick(() => {
                    Livewire.hook('morph.removed', (el, component) => {
                        if (el.el.nodeName === 'INPUT' && el.el.getAttribute('x-ref') === 'tinymce') {
                            tinymce.get(el.el.id)?.remove();
                        }
                    });
                });
            }
         })()"
        x-cloak
        wire:ignore
    >
        @unless($isDisabled())
            <input
                id="tiny-editor-{{ $getId() }}"
                type="hidden"
                x-ref="tinymce"
                placeholder="{{ $getPlaceholder() }}"
            >
        @else
            <div
                x-html="state"
                class="block w-full max-w-none rounded-lg border border-gray-300 bg-white p-3 opacity-70 shadow-sm transition duration-75 prose dark:prose-invert dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            ></div>
        @endunless
    </div>
</x-dynamic-component>
