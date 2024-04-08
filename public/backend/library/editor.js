function ckeditor4(elementId, elementHeight) {
    if (typeof elementHeight == 'undefined') {
        elementHeight = 100;
    }
    CKEDITOR.replace(elementId, {
        height: parseInt(elementHeight),
        removeButtons: "",
        entities: true,
        allowedContent: true,
        toolbarGroup: [
            { name: 'clipboard', groups: ['clipboard', 'undo'] },
            { name: 'editing', groups: ['find', 'selection', 'spellchecker'] },
            { name: 'links' },
            { name: 'insert' },
            { name: 'forms' },
            { name: 'tools' },
            { name: 'document', groups: ['mode', 'document', 'doctools'] },
            { name: 'others' },
            '/',
            { name: 'basicstyles', groups: ['basicstyles', 'cleanup'] },
            { name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'] },
            { name: 'styles' },
            { name: 'colors' },
            { name: 'about' }
        ]
    })
}
function setupCkeditor() {
    document.querySelectorAll('.ck-editor').forEach(item => {
        let elementId = item.id;
        let elementHeight = item.dataset.height;
        ckeditor4(elementId, elementHeight)
    })
}



setupCkeditor()