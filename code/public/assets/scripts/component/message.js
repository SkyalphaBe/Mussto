export default function Message(){
    var messageElt = document.createElement("p");
    var timerMessage;

    messageElt.showMessage = (message) => {
        messageElt.innerText = message;
        if (timerMessage){
            clearTimeout(timerMessage);
        }
        timerMessage = setTimeout(() => {
            messageElt.innerText = "";
        }, 5000);
    }

    return messageElt;
}