function BrowseServerInput(object, type) {
    if (typeof type == 'undefined') {
        type = 'Images'
    }
    var finder = new CKFinder();
    finder.resourceType = type;

    finder.selectActionFunction = function (fileUrl, data) {
        object.value = fileUrl;
    }

    finder.popup();
}



function browseServerCkeditor(object, type, target) {
    if (typeof type == 'undefined') {
        type = 'Images'
    }
    var finder = new CKFinder();
    finder.resourceType = type;

    finder.selectActionFunction = function (fileUrl, data, allFiles) {
        for (var i = 0; i < allFiles.length; i++) {
            let image = allFiles[i].url
            CKEDITOR.instances[target].insertHtml(`
            <figure>
              <img src="${image}" alt="${image}" >
              <figcaption>Nhập vào mô tả cho ảnh</figcaption>
            </figure>
            `)
        }
    }

    finder.popup();
}
function browseServerAlbum() {
    type = 'Images'
    var finder = new CKFinder();
    finder.resourceType = type;

    finder.selectActionFunction = function (fileUrl, data, allFiles) {
        let html = '';
        for (var i = 0; i < allFiles.length; i++) {
            let image = allFiles[i].url
            html += '<li class="ui-state-default">'
            html += '    <div class="thumb">'
            html += '        <span class="image img-scaledown">'
            html += '            <img src="' + image + '" alt="' + image + '">'
            html += '            <input type="hidden" name="album[]" value="' + image + '"  >'
            html += '        </span>'
            html += '        <a class="delete-image"><i class="fa fa-trash"></i></a>'
            html += '    </div>'
            html += '</li>'
        }

        document.querySelector('.click-to-upload').classList.add("hidden")
        document.querySelector('.upload-list').classList.remove("hidden")
        document.querySelector('#sortable').insertAdjacentHTML('beforeend', html)
    }

    finder.popup();
}

