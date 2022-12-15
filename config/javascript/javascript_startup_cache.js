window.onload = function () {
    let form = document.getElementById("form");
    let inputs = form.children;
    for (let i = 0; i < inputs.length; i++) {
        let el = inputs[i];
        if (el.tagName.toLowerCase() != "input" || el.attributes["type"].value != "text") {
            continue
        }
        let cachedVal = localStorage.getItem(el.attributes["id"].value)
        if (cachedVal != null) {
            el.value = cachedVal;
            console.log(el.value);
        }
    }
}
function cacheInput(e) {
    localStorage.setItem(e.attributes["id"].value, e.value)
}
function clearCache() {
    localStorage.clear()
}