let up = document.querySelector(".up");


window.addEventListener("scroll", () => {
    if (window.pageYOffset >= 300) {
        up.style.visibility = "visible";
    } else {
        up.style.visibility = "hidden";
    }
});


let comments = document.getElementsByClassName("hell");
let overlay = document.querySelector(".overlay");

for (let i = 0; i < comments.length; i++) {
    comments[i].onclick = function () {
    overlay.style.display = "flex";
   }    
}


$(document).ready(function () {
    // setInterval(function () {
        $(".veiw").load("controllers/get-posts.php");
        
    // }, 1000)
});

setInterval(() => {
    $.ajax({
        url: 'controllers/bansetter.php',
        success: function (data) {

        }
    })
}, 60000)