export default function Loader(){
    var loaderDiv = document.createElement("div");
    loaderDiv.className = "loader";
    loaderDiv.show = () => {
        loaderDiv.innerHTML = "<div class='lds-ellipsis'><div></div><div></div><div></div><div></div></div>";
    }
    loaderDiv.hide = () => {
        loaderDiv.innerHTML = "";
    }

    return loaderDiv;
}