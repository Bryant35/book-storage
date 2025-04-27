import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Highlight from 'https://esm.sh/@tiptap/extension-highlight@2.6.6';
import Underline from 'https://esm.sh/@tiptap/extension-underline@2.6.6';
import Link from 'https://esm.sh/@tiptap/extension-link@2.6.6';
import TextAlign from 'https://esm.sh/@tiptap/extension-text-align@2.6.6';
import Subscript from 'https://esm.sh/@tiptap/extension-subscript@2.6.6';
import Superscript from 'https://esm.sh/@tiptap/extension-superscript@2.6.6';
import TextStyle from 'https://esm.sh/@tiptap/extension-text-style@2.6.6';
import FontFamily from 'https://esm.sh/@tiptap/extension-font-family@2.6.6';
import { Color } from 'https://esm.sh/@tiptap/extension-color@2.6.6';
import Bold from 'https://esm.sh/@tiptap/extension-bold@2.6.6';

document.addEventListener("DOMContentLoaded", function () {
    const wysiwygElement = document.getElementById("wysiwyg");
    const hiddenInput = document.getElementById("editor");

    const FontSizeTextStyle = TextStyle.extend({
        addAttributes() {
            return {
                fontSize: {
                    default: null,
                    parseHTML: element => element.style.fontSize,
                    renderHTML: attributes => {
                        if (!attributes.fontSize) {
                            return {};
                        }
                        return { style: 'font-size: ' + attributes.fontSize };
                    },
                },
            };
        },
    });

    if (!wysiwygElement || !hiddenInput) return;

    const editor = new Editor({
        element: wysiwygElement,
        extensions: [
            StarterKit,
            Bold,
            Highlight,
            Underline,
            Subscript,
            Superscript,
            FontSizeTextStyle,
            Link,
            TextAlign.configure({ types: ['heading', 'paragraph'] }),
        ],
        content: hiddenInput.value || "<p>Write short book content...</p>",
        onUpdate({ editor }) {
            hiddenInput.value = editor.getHTML();
        },
    });

    document.getElementById("toggleBoldButton")?.addEventListener("click", () => {
        editor.chain().focus().toggleBold().run()
    })

    document.getElementById("toggleItalicButton")?.addEventListener("click", () => {
        editor.chain().focus().toggleItalic().run()
    })

    document.getElementById("toggleUnderlineButton")?.addEventListener("click", () => {
        editor.chain().focus().toggleUnderline().run()
    })

    document.getElementById("toggleStrikeButton")?.addEventListener("click", () => {
        editor.chain().focus().toggleStrike().run()
    })

    document.getElementById('toggleSubscriptButton').addEventListener('click', () => editor.chain().focus().toggleSubscript().run());

    document.getElementById('toggleSuperscriptButton').addEventListener('click', () => editor.chain().focus().toggleSuperscript().run());

    document.getElementById('toggleHighlightButton').addEventListener('click', () => {
        const isHighlighted = editor.isActive('highlight');
        // when using toggleHighlight(), judge if is is already highlighted.
        editor.chain().focus().toggleHighlight({
            color: isHighlighted ? undefined : '#ffc078' // if is already highlighted，unset the highlight color
        }).run();
    });

    document.getElementById('toggleCodeButton').addEventListener('click', () => {
        editor.chain().focus().toggleCode().run();
    });

    const textSizeDropdown = FlowbiteInstances.getInstance('Dropdown', 'textSizeDropdown');

    // Loop through all elements with the data-text-size attribute
    document.querySelectorAll('[data-text-size]').forEach((button) => {
        button.addEventListener('click', () => {
            const fontSize = button.getAttribute('data-text-size');

            // Apply the selected font size via pixels using the TipTap editor chain
            editor.chain().focus().setMark('textStyle', { fontSize }).run();

            // Hide the dropdown after selection
            textSizeDropdown.hide();
        });
    });

    document.getElementById("toggleLeftAlignButton")?.addEventListener("click", () => {
        editor.chain().focus().setTextAlign('left').run()
    })
    document.getElementById("toggleCenterAlignButton")?.addEventListener("click", () => {
        editor.chain().focus().setTextAlign('center').run()
    })
    document.getElementById("toggleRightAlignButton")?.addEventListener("click", () => {
        editor.chain().focus().setTextAlign('right').run()
    })
    document.getElementById("toggleJustifyButton")?.addEventListener("click", () => {
        editor.chain().focus().setTextAlign('justify').run()
    })

    // Make sure the latest content is submitted
    document.querySelector("form")?.addEventListener("submit", () => {
        hiddenInput.value = editor.getHTML();
    });
});
