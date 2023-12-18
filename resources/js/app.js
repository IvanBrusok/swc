import './bootstrap';

var currentId = false;

function allEvents() {
    $.post("/event/all", function (data) {
        $('#allEvents').empty();
        for (let i in data) {
            $('#allEvents').append(`<li class="nav-item">
                         <a href="#" class="nav-link align-middle px-0" data-id="` + data[i].id + `">
                             <span class="ms-1 d-none d-sm-inline">` + data[i].title + `</span>
                         </a>
                     </li>`);

        }
        $('#allEvents .nav-item').on('click', function () {
            let id = $(this).find('a').attr('data-id');
            insertContent(id);
        })
    });
}

function myEvents() {
    $.post("/event/member", function (data) {
        $('#myEvents').empty();
        for (let i in data) {
            $('#myEvents').append(`<li class="nav-item">
                         <a href="#" class="nav-link align-middle px-0" data-id="` + data[i].id + `">
                             <span class="ms-1 d-none d-sm-inline">` + data[i].title + `</span>
                         </a>
                     </li>`);
        }
        $('#myEvents .nav-item').on('click', function () {
            let id = $(this).find('a').attr('data-id');
            insertContent(id);
        })

    });
}


function insertContent(id){
    currentId = id;
    $.post("/event/get/"+id, function(data) {
        $('.content').empty();
        let str = `<h1 class="title">`+data.title+`</h1>
            <h2 class="description">`+data.description+`</h2>
            <h3 class="date">`+data.created_at+`</h3>
            <span class="fs-5 d-none d-sm-inline">Участники</span>
            <ul class="nav nav-pills flex-column mb-0 align-items-center align-items-sm-start">`;
        for(let n of data.members){
            str += `<li class="nav-item">
                         <a href="#" class="nav-link align-middle px-0">
                             <span class="ms-1 d-none d-sm-inline">`+n.first_name+` '`+n.login+`' `+n.last_name+`</span>
                         </a>
                     </li>`;
        }
        str += `</ul>`;
        str += (data.participate) ? `<button class="btn btn-success btn-dismember">Отменить участие</button>` : `<button class="btn btn-success btn-member">Принять участие</button>`;
        $('.content').append(str);
        $('.btn-member').on('click', function(){
            $.post("/event/participate/"+id, function(data){
                allEvents();
                myEvents();
                insertContent(id);
            });
        });
        $('.btn-dismember').on('click', function(){
            $.post("/event/refuse/"+id, function(data){
                allEvents();
                myEvents();
                insertContent(id);
            });
        });
    });

}



allEvents();
myEvents();

setTimeout(function(){
    allEvents();
    if(currentId) insertContent(currentId);
}, 30000);
