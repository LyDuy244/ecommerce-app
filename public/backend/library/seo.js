const nameInput = document.querySelector("input[name='name']");
const metaTitle = document.querySelector(".meta-title")
const canonical = document.querySelector(".canonical")
document.querySelector("input[name='meta_title']").addEventListener('input', function (event) {
    let value = event.target.value;
    metaTitle.textContent = value;
})

document.querySelector("input[name='canonical']").addEventListener('input', function (event) {
    let value = event.target.value;
    value = removeUtf8(value);
    canonical.textContent = BASE_URL + value + '.html';
})

document.querySelector("textarea[name='meta_description']").addEventListener('input', function (event) {
    let value = event.target.value;
    document.querySelector(".meta-description").textContent = value;
})

const baseUrl = document.querySelector('.baseUrl')
document.querySelectorAll(".seo-canonical").forEach(item => item.style.paddingLeft = baseUrl.offsetWidth + 'px')



function removeUtf8(str) {
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẫ|ẩ|ă|ằ|ắ|ẳ|ẵ|ặ/g, "a");
    str = str.replace(/è|é|ẻ|ẽ|ẹ|ề|ế|ễ|ể|ệ/g, "e");
    str = str.replace(/ì|í|ỉ|ĩ|ị/g, "i");
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ổ|ỗ|ộ|ơ|ờ|ớ|ỡ|ở|ợ/g, "o");
    str = str.replace(/ù|ú|ủ|ũ|ụ|ư|ừ|ứ|ữ|ử|ự/g, "u");
    str = str.replace(/ỳ|ý|ỷ|ỹ|ỵ/g, "y");
    str = str.replace(/đ/g, "d");
    str = str.replace(/!|@|%|\*|\^|\(|\)|\+|\=|\<|\>|\?|\,|\.|\:|\;|\`|\-| |\'|\"|\&|\#|\$/g, "-");
    str = str.replace(/-+-/g, "-");
    str = str.replace(/^\-+|\-+$/g, "a");
    return str;
}