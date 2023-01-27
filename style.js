//on click
var buttons = document.getElementById("buttons");

buttons.onclick = function(){
    alert("We have clicked on the paragraph");
};

//append
var newListItem = document.createElement("li");
var entireUndorderedList = document.getElementById("mainSiteList");

newListItem.innerHTML = "DOM Manipulation";
entireUndorderedList.appendChild(newListItem);

//2nd append
var newListItem = document.createElement("li");
var entireUndorderedList = document.getElementById("mainSiteList");

var newListText = document.createTextNode("Another DOM Manipulation");

newListItem.appendChild( newListText);
entireUndorderedList.appendChild(newListItem);


//style
function hide(elementId) {
    document.getElementById(elementId).style.display = 'none';
}
window.onload = function() {
    setTimeout("hide('backgroundBody')", 3000);
}

//attribute
var grab = document.getElementById("grab");
grab.setAttribute('class', 'red');
