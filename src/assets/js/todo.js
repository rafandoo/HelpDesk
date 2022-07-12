const date = new Date().toDateString() ;
const setdate = document.querySelector(".setdate");
setdate.innerHTML = date;



setInterval(function(){
const time = new Date().toLocaleTimeString();
const settime = document.querySelector(".settime");

settime.innerHTML = time;
},500);

var add_task=document.querySelector(".addtask button");
var task_input=document.querySelector(".addtask textarea");

var numtask = document.querySelector(".numtask");
var shown=document.querySelector(".added_tasks");

add_task.addEventListener('click',function(){
var added_li=document.querySelectorAll(".added_tasks li");
var task=document.querySelector(".addtask textarea");
var i=Math.floor(Math.random() * (999999 - 10000) * 10000);
if(task_input.value.length>5){

var line = document.createElement("li");
line.setAttribute("id", i);

// var list_items="<div class='content'><span class='tick' onclick='Tick("+i+")'><i id='checked"+i+"' class='fa fa-check d-none'></i></span>
//     <p><strike id='strike"+i+"' class='strike-none'>"+task_input.value+"</strike></p>
// </div><span onclick='Delete("+i+")'><i class='fa fa-trash'></i></span>";

var list_items=`<div class="content"><span class="tick" onclick="Tick(${i})"><i id="checked${i}" class="fa fa-check d-none"></i></span>
    <p><strike id="strike${i}" class="strike-none">${task_input.value}</strike></p>
</div><span onclick="Delete(${i})"><i class="fa fa-trash"></i></span>`;



line.innerHTML = list_items;
shown.appendChild(line);
task.value = " ";


numtask.innerHTML = added_li.length+1;


}
});
function Tick(list_id){
var check = document.getElementById("checked"+list_id);
check.classList.toggle('d-none');

var strike = document.getElementById("strike"+list_id);
strike.classList.toggle('strike-none');

}

function Delete(list_id){
var added_li=document.querySelectorAll(".added_tasks li");

var elem = document.getElementById(list_id);
shown.removeChild(elem);
numtask.innerHTML = added_li.length-1;
}