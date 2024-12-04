import $ from 'jquery';
import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import TextStyle from '@tiptap/extension-text-style';
import Underline from '@tiptap/extension-underline';
import Link from '@tiptap/extension-link';
import Placeholder from '@tiptap/extension-placeholder';
$(() => {
    var editor = new Editor({
        element: $('#editor').get(0),
        extensions: [
            StarterKit.configure({
                heading: {
                    levels: [1, 2, 3]
                },
                horizontalRule: false,
                codeBlock: false,
                blockquote: false,
                hardBreak: false
            }),
            TextStyle,
            Underline,
            Placeholder.configure({
                placeholder: 'Write something …',
            }),
            Link.configure({
                openOnClick: false,
                autolink: true,
                defaultProtocol: 'https',
                protocols: ['http', 'https'],
                isAllowedUri: (url, ctx) => {
                    try {
                        const parsedUrl = url.includes(':') ? new URL(url) : new URL(`${ctx.defaultProtocol}://${url}`)

                        if (!ctx.defaultValidate(parsedUrl.href)) {
                            return false
                        }

                        const disallowedProtocols = ['ftp', 'file', 'mailto']
                        const protocol = parsedUrl.protocol.replace(':', '')

                        if (disallowedProtocols.includes(protocol)) {
                            return false
                        }

                        const allowedProtocols = ctx.protocols.map(p => (typeof p === 'string' ? p : p.scheme))

                        if (!allowedProtocols.includes(protocol)) {
                            return false
                        }

                        const disallowedDomains = ['example-phishing.com', 'malicious-site.net']
                        const domain = parsedUrl.hostname

                        if (disallowedDomains.includes(domain)) {
                            return false
                        }

                        return true
                    } catch (error) {
                        return false
                    }
                },
                shouldAutoLink: url => {
                    try {
                        const parsedUrl = url.includes(':') ? new URL(url) : new URL(`https://${url}`)

                        const disallowedDomains = ['example-no-autolink.com', 'another-no-autolink.com']
                        const domain = parsedUrl.hostname

                        return !disallowedDomains.includes(domain)
                    } catch (error) {
                        return false
                    }
                },

            }),
        ],
    });


    function setLink() {
        const previousUrl = editor.getAttributes('link').href
        const url = window.prompt('URL', previousUrl)

        if (url === null) {
            return
        }

        if (url === '') {
            editor.chain().focus().extendMarkRange('link').unsetLink().run()
            return
        }

        editor.chain().focus().extendMarkRange('link').setLink({ href: url }).run()
    };

    // update button state
    function updateButtonState() {
        if (editor.isActive('bold')) {
            $('#bold-button').attr('data-is-active', '');
        } else {
            $('#bold-button').removeAttr('data-is-active');
        }

        if (editor.isActive('italic')) {
            $('#italic-button').attr('data-is-active', '');
        } else {
            $('#italic-button').removeAttr('data-is-active');
        }

        if (editor.isActive('underline')) {
            $('#underline-button').attr('data-is-active', '');
        } else {
            $('#underline-button').removeAttr('data-is-active');
        }

        if (editor.isActive('heading', { level: 1 })) {
            $('#h1-button').attr('data-is-active', '');
        } else {
            $('#h1-button').removeAttr('data-is-active');
        }

        if (editor.isActive('heading', { level: 2 })) {
            $('#h2-button').attr('data-is-active', '');
        } else {
            $('#h2-button').removeAttr('data-is-active');
        }

        if (editor.isActive('heading', { level: 3 })) {
            $('#h3-button').attr('data-is-active', '');
        } else {
            $('#h3-button').removeAttr('data-is-active');
        }

        if (editor.isActive('bulletList')) {
            $('#ul-button').attr('data-is-active', '');
        } else {
            $('#ul-button').removeAttr('data-is-active');
        }

        if (editor.isActive('orderedList')) {
            $('#ol-button').attr('data-is-active', '');
        } else {
            $('#ol-button').removeAttr('data-is-active');
        }

        if (editor.isActive('link')) {
            $('#link-button').attr('data-is-active', '');
        } else {
            $('#link-button').removeAttr('data-is-active');
        }

        if (editor.isActive('strike')) {
            $('#strike-button').attr('data-is-active', '');
        } else {
            $('#strike-button').removeAttr('data-is-active');
        }
    }
    editor.on('transaction', () => {
        updateButtonState();
    });

    // button on click
    var $document = $(document);
    $document.on('click', '#bold-button', function () {
        editor.chain().focus().toggleBold().run();
        updateButtonState();
    });
    $document.on('click', '#italic-button', function () {
        editor.chain().focus().toggleItalic().run();
        updateButtonState();
    });
    $document.on('click', '#underline-button', function () {
        editor.chain().focus().toggleUnderline().run();
        updateButtonState();
    });
    $document.on('click', '#h1-button', function () {
        editor.chain().focus().toggleHeading({ level: 1 }).run();
        updateButtonState();
    });
    $document.on('click', '#h2-button', function () {
        editor.chain().focus().toggleHeading({ level: 2 }).run();
        updateButtonState();
    });
    $document.on('click', '#h3-button', function () {
        editor.chain().focus().toggleHeading({ level: 3 }).run();
        updateButtonState();
    });
    $document.on('click', '#ul-button', function () {
        editor.chain().focus().toggleBulletList().run();
        updateButtonState();
    });
    $document.on('click', '#ol-button', function () {
        editor.chain().focus().toggleOrderedList().run();
        updateButtonState();
    });
    $document.on('click', '#link-button', function () {
        setLink();
        updateButtonState();
    });
    $document.on('click', '#unlink-button', function () {
        editor.chain().focus().unsetLink().run();
        updateButtonState();
    });
    $document.on('click', '#strike-button', function () {
        editor.chain().focus().toggleStrike().run();
        updateButtonState();
    });
    window.editor = editor;
})