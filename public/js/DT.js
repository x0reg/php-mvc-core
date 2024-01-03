
function blockDevtool() {
    window.location.href = "https://google.com"
}
class devToolIsChecked extends Error {
    toString() {

    }

    get message() {
        blockDevtool()
    }
}

console.log(new devToolIsChecked());