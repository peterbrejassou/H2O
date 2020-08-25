var numbers = document.getElementsByClassName("cursor-number");

for (var i=0; i < numbers.length; i++) {
    numbers[i].onclick = function(){
        var siblings = this.parentNode.children;
        for (var i=0; i < siblings.length; i++) {
            siblings[i].classList.remove("chosen");
        }
        this.classList.add("chosen");
    }
};


// PARTIE SIMULATEUR
var btn_question_1 = document.getElementById('btn-question-1');
var btn_question_2 = document.getElementById('btn-question-2');
var btn_question_3 = document.getElementById('btn-question-3');

if(btn_question_1 != null){
    btn_question_1.addEventListener("click", function(){
        document.getElementById('simu-question-1').classList.add("hidden");
        document.getElementById('simu-question-2').classList.remove("hidden");
    });
}

if(btn_question_2 != null){
    btn_question_2.addEventListener("click", function(){
        document.getElementById('simu-question-2').classList.add("hidden");
        document.getElementById('simu-question-3').classList.remove("hidden");
    });
}

if(btn_question_3 != null){
    btn_question_3.addEventListener("click", function(){
        document.getElementById('simu-question-3').classList.add("hidden");
        document.getElementById('results').classList.remove("hidden");
    });
}

var menuMobile = document.getElementById('menu-mobile');
var btnCloseMenu = document.getElementById('close-menu-mobile');
var btnMenu = document.getElementById('btnMenu');
btnCloseMenu.addEventListener("click", function(){
    menuMobile.classList.add("hidden");
});
btnMenu.addEventListener("click", function(){
    menuMobile.classList.remove("hidden");
});