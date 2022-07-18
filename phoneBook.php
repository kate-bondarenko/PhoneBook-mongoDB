<?php
require "connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Телефонная книга пользователя</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="shortcut icon" href="fav.ico" type="image/x-icon"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
<script>

    var ajax = new XMLHttpRequest();
    var _item;
    var _itemID;

    document.addEventListener("DOMContentLoaded", function() {
        var error = document.getElementById("error");
        request1();
        document.querySelector('#phoneBook').addEventListener('click', function(e){
        _itemID = e.target.id;
        console.log(_itemID);
        _item = e.target.innerHTML;
        console.log(_item);
        });
    });

    function over(e) { 
        var e = e || window.event;
        var elem = e.srcElement || e.target;
        var relatedTarget = e.relatedTarget || e.fromElement
        relatedTarget.style.background="";
        relatedTarget.style.color="";
        relatedTarget.style.border="";
        if (elem.tagName == 'p')
            return;
        elem.style.background="#FFFF00";
        elem.style.color="#000";
        elem.style.cursor="pointer";
        elem.style.border="1px solid #FFFF00";
    };

    function out(e) { 
        var e = e || window.event;
        var elem = e.srcElement || e.target;
        var relatedTarget = e.relatedTarget || e.fromElement
        relatedTarget.style.background="";
        if (elem.tagName == 'p')
            return;
        elem.style.background="#FF7F50";
        elem.style.border="0px";
    };

    function hideAddForm(){
        if (document.getElementById("hideAddForm").style.display == "block") { 
            document.getElementById("hideAddForm").style.display = "none";
        }
        else {
            document.getElementById("hideAddForm").style.display = "block";
        }
    };

    function hideFilterForm(){
        if (document.getElementById("hideFilterForm").style.display == "block") { 
            document.getElementById("hideFilterForm").style.display = "none";
        }
        else {
            document.getElementById("hideFilterForm").style.display = "block";
        }
    };

    function hideEditForm(){
       if (document.getElementById("hideEditForm").style.display == "block") { 
            document.getElementById("hideEditForm").style.display = "none";
        }
        else {
            document.getElementById("hideEditForm").style.display = "block";
        }
    };

    function update(data) {
        let rows = JSON.parse(data);
        let parent = document.querySelector('#phoneBook');
        parent.innerHTML = "";
        for(var i=0; i < rows.length; i++) {
            let id = rows[i]._id;
            var p = document.createElement('p');
            p.setAttribute('id',id);
            p.setAttribute('onmouseover','over(event)');
            p.setAttribute('onmouseout','out(event)');
            parent.appendChild(p);  
            var array = Object.entries(rows[i]);
            let result = "";
            for (const [key, value] of array) {
                if(key != '_id')
                result += [`${key}: ${value}`] + " | ";   
                }
                document.getElementById(id).innerHTML = result;
                //console.log(document.getElementById(id).innerHTML); 
                console.log(result); 
        }
    };

    function loadDataReq1() {
        if(ajax.readyState === 4) {
            if(ajax.status == 200) {
                document.getElementById("phoneBook").style.display = "block";
                error.style.display = "none";
                console.dir(ajax.response);
                update(ajax.response);
            }
        }
    };

    function request1() {
        ajax.onreadystatechange = loadDataReq1;
        ajax.open("POST", "loagingPhoneBook.php", true);
        ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        ajax.send();      
    };

    function filterRequest() {
        let filter = document.getElementById("filter").value;
        $.post({
            url: "filter.php",
            data:{ filter: filter }
            }).done(function(data) {
                console.dir(data);
                if(data == 0) {
                    document.getElementById("hideFilterForm").style.display = "block";
                    error.style.display = "block";
                    error.innerHTML = "Вы не ввели данные!";
                }
                else {
                    error.style.display = "none";
                    let rows = JSON.parse(data);
                    let counter = 0;
                    document.getElementById("phoneBook").style.display = "block";
                    document.getElementById("phoneBook").innerHTML = "";
                    for(var i = 0; i < rows.length; i++) {
                        let id = rows[i]._id;
                        var filter = document.getElementById("filter").value;
                        let parent = document.querySelector('#phoneBook');
                        var p = document.createElement('p');
                        p.setAttribute('id',id);
                        p.setAttribute('onmouseover','over(event)');
                        p.setAttribute('onmouseout','out(event)');
                        parent.appendChild(p);  
                        var array = Object.entries(rows[i]);
                        if(filter in rows[i]) {
                            let result = "";
                            for (const [key, value] of array) {
                                if(key != '_id') {
                                    result += [`${key}: ${value}`];   
                                }
                            }
                            document.getElementById(id).innerHTML = result; 
                            console.log(document.getElementById(id).innerHTML);
                            //console.log(result); 
                        }
                        else {
                            ++counter;
                        }
                    } 
                    if(counter == rows.length) {
                        document.getElementById("hideFilterForm").style.display = "block";
                        document.getElementById("phoneBook").style.display = "none";
                        error.style.display = "block";
                        error.innerHTML = "Вы ввели неверные данные!";
                    }
                }                    
            });       
    };

    function add_field() {
        var x = document.getElementById("hideAddForm");

        var p1 = document.createElement("p");
        p1.innerHTML = "Input the name of field:";
        var pos1 = x.childElementCount;

        var name_field = document.createElement("input");
        name_field.setAttribute("type", "text");
        name_field.setAttribute("class", "input");
        name_field.setAttribute("id", "name_field[]");
        name_field.setAttribute("name", "name_field[]");
        name_field.setAttribute("required", "required");
        var pos2 = x.childElementCount; 
        
        var p2 = document.createElement("p");
        p2.innerHTML = "Input the value of field:";
        var pos3 = x.childElementCount;

        var value_field = document.createElement("input");
        value_field.setAttribute("type", "text");
        value_field.setAttribute("class", "input");
        value_field.setAttribute("id", "value_field[]");
        value_field.setAttribute("name", "value_field[]");
        value_field.setAttribute("required", "required");
        var pos4 = x.childElementCount;

        //x.insertBefore(p1, x.childNodes[pos1]);
        //x.insertBefore(name_field, x.childNodes[pos2]);
        //x.insertBefore(p1, x.childNodes[pos3]);
       // x.insertBefore(value_field, x.childNodes[pos4]);

        // var submit = document.createElement("input");
        // submit.setAttribute("type", "submit");
        // submit.setAttribute("class", "button");
        // submit.setAttribute("value", "Добавить запись");

        x.appendChild(p1);
        x.appendChild(name_field);
        x.appendChild(p2);
        x.appendChild(value_field);
        // x.appendChild(submit);
    };

    function remove_item() {
        //console.log(_item);
        if(_item != undefined) {
            error.style.display = "none";
            const result = confirm(`Вы действительно хотите удалить ${_item} запись?`);
            //const result = confirm(`Вы действительно хотите удалить эту запись?`);
            if (result) {
                var id = document.getElementById(_itemID).id;
                $.post({
                    url: "removeItem.php",
                    dataType : "text",
                    data:{ _id: id }
                    }).done(function(data) {
                        console.dir(data);
                }); 
            }
        
        }
        else {
            error.style.display = "block";
            error.innerHTML = "Вы не выбрали запись для удаления";
        }
        _item = undefined;
      
        
    };

    function edit_item() {
        //console.log(_item);
        if(_item != undefined) {
            error.style.display = "none";
            const result = confirm(`Вы действительно хотите редактировать ${_item} запись?`);
            if (result) {
                let editName = document.getElementById("editName").value;
                let editNewValue = document.getElementById("editNewValue").value;
                let id = document.getElementById(_itemID).id;
                $.post({
                     url: "editItem.php",
                    dataType : "text",
                    data:{ _id: id, editName: editName, editNewValue: editNewValue }
                    }).done(function(data) {
                        console.dir(data);
                        if(data == 0) {
                            document.getElementById("hideEditForm").style.display = "block";
                            error.style.display = "block";
                            error.innerHTML = "Вы не ввели данные!";
                        }
                        else {
                            error.style.display = "none";
                            document.getElementById("hideEditForm").style.display = "none";
                        }
                        
                });
                 
            }  
        }          
        else {
            document.getElementById("hideEditForm").style.display = "block";
            error.style.display = "block";
            error.innerHTML = "Вы не выбрали запись для редактирования";
        }
        
    };

</script>
</head>
<body>
    <div class="title">Phone Book</div> 
    <?php if ( isset($_SESSION['user']) ) :
        $user = json_decode($_SESSION['user']) ?>
    <div id="hello">Привет, <?php echo $user->Name;?> 
    <a href="logout.php" ><input type="button" class="button" value="Выйти"/></a>
    </div> 
    <input type="button" class="button" value="Обновить содержимое телефонной книги" onclick="request1()"/></a>
    <input type="button" class="button" value="Добавить запись" onclick="hideAddForm()"/></a>
    <input type="button" class="button" value="Указать фильтр" onclick="hideFilterForm()"/></a>
    <input type="button" class="button" value="Удалить запись" onclick="remove_item()"/></a>
    <input type="button" class="button" value="Редактировать запись" onclick="hideEditForm()"/></a>
    <div id="error"> </div>
    <div id="phoneBook"> </div>
    <form id="hideAddForm" method="post" action="addRecords.php">
    <p><input type="submit" class="button" value="Добавить запись"/></a></p>
    <p>Input the title:</p>
    <p><input class="input" id="title" name="title" type="text" maxlength=50 placeholder="Ivan Ivanov" required="required"></p>
    <p>Input phone:</p>
    <p><input class="input" id="phone" name="phone" type="tel" maxlength=15 placeholder="+(380)995683345" required="required" ></p>
    <p><input class="addButton" type="button" name="addField" value="Добавить поле" onclick="add_field()"/></p>
    </form>
    <div id="hideFilterForm">
    <p>Input the field you want to display:</p>
    <p><input class="input" id="filter" name="filter" type="text" maxlength=50 placeholder="phone"></p>
    <p><input class="addButton" type="button" name="filterButton" value="Ок" onclick="filterRequest(); hideFilterForm()"/></p> 
    </div>
    <div id="hideEditForm">
    <p>Input the name of field you want to edit:</p>
    <p><input class="input" id="editName" name="editName" type="text" maxlength=50 placeholder="title"></p>
    <p>Input new value of field you want to save:</p>
    <p><input class="input" id="editNewValue" name="editNewValue" type="text" maxlength=50 placeholder="Ivan"></p>
    <p><input class="addButton" type="button" name="editButton" value="Ок" onclick="edit_item()"/></p> 
    </div>

    <?php else : 
        header('Location:main.php');  
    endif; ?>
</body>
</html>

