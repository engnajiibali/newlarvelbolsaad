@extends('layouts.admin')
@section('content')
<div class="content">
<div class="row">
<div class="col-sm-10 mx-auto">
<a href="{{asset('devices/')}}" class="back-icon d-flex align-items-center fs-12 fw-medium mb-3 d-inline-flex">
<span class=" d-flex justify-content-center align-items-center rounded-circle me-2">
<i class="ti ti-arrow-left"></i>
</span>
Back to List
</a>
<div class="card">
<div class="card-body">

<!-- Company Detail -->
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">{{$subTitle}}</h4>
</div>
<hr>
<div class="modal-body pb-0">
<form id="pForm"  method="post" action="{{route('userRole.update',$role->id)}}" enctype="multipart/form-data">
@csrf
@method('put')
<!--     <button type="submit" class="btn btn-primary pull-right" style="margin-right: 2%">Save changes</button><br>
<hr> -->
<div>
@if (Session::has('success'))
<div class="alert alert-success alert-dismissible">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<h4><i class="icon fa fa-check"></i> {{Session::get('success')}}</h4>
</div>
@endif
@if (Session::has('fail'))
<div class="alert alert-danger alert-dismissible">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<h4><i class="icon fa fa-check"></i> {{Session::get('fail')}}</h4>
</div>
@endif
</div>

<div class="modal-body pb-0">
<div class="row">

<div class="col-md-12">
<div class="mb-3">
    <input type="hidden" id="hmenu1" name="menu" class="" value="{{$role->role_menu}}">
<label class="form-label"> Role Name</label>
<input type="text" class="form-control"  name="Role" id="role" placeholder="Role Name" value="{{$role->Role}}">
<span class="text-danger">@error('Role') {{$message}} @enderror</span>
</div>  
</div>




<div class="col-md-12">
<div class="mb-3">
<label class="form-label">  Role Description</label>
<div class="pass-group">

<textarea class="form-control" placeholder="Enter description..." name="Description" id="dec">{{$role->description}} </textarea>

</div>
</div>  
</div>
<div class="col-md-12">
<div class="mb-3">
<label class="form-label">  Permissions</label>
<div class="pass-group">

<div class="row">
<!-- Select All Permission -->
<div class="col-md-2">
<label>
<input type="checkbox" id="selectAll"> Select All
</label>
</div>

<!-- Read Permission -->
    <div class="col-md-2">
        <label>
            <input type="checkbox" name="Read" value="{{$role->Read_permision}}" class="permission-checkbox" {{ $role->Read_permision == 1 ? 'checked' : '' }}> Show
        </label>
    </div>

    <!-- Write Permission -->
    <div class="col-md-2">
        <label>
            <input type="checkbox" name="Write" value="{{$role->Write_permision}}" class="permission-checkbox" {{ $role->Write_permision == 1 ? 'checked' : '' }}> Write
        </label>
    </div>

    <!-- Edit Permission -->
    <div class="col-md-2">
        <label>
            <input type="checkbox" name="Edit" value="{{$role->Edit_permision}}" class="permission-checkbox" {{ $role->Edit_permision == 1 ? 'checked' : '' }}> Edit
        </label>
    </div>

    <!-- Delete Permission -->
    <div class="col-md-2">
        <label>
            <input type="checkbox" name="Delete" value="{{$role->Delete_permision}}" class="permission-checkbox" {{ $role->Delete_permision == 1 ? 'checked' : '' }}> Delete
        </label>
    </div>

</div>

</div>
</div>  
</div>
</div>
<hr>
<div class="row">
<div class="col-md-12">

<div class="card">

<div class="card-body p-0">
<div class="table-responsive">
        <span class="text-danger">@error('menu') {{$message}} @enderror</span>
<table class="table ">
    <thead>
<tr>
<th style="width: 8%"><label><input type="checkbox" id="check-all"> All</label></th>
<th>Menu Name</th>
</tr>
</thead>
<tbody>

@foreach ($menus as $menu)
<tr>
<th width="5%">
<label>
<input type="checkbox" class="allmenuId" id="menuId{{ $menu['id'] }}"> All
</label>
</th>
<th>{{ $menu['menu_name'] }}</th>

</tr>
@foreach ($submenus as $submenu)
@if ($submenu['menu_id'] == $menu['id'])
<tr>
<td>
<input type="hidden" value="{{ $submenu['menu_id'] }}" id="menuId{{ $submenu['submenu'] }}">
<input type="checkbox" id="check1-{{ $submenu["id"] }}"
class="chkbox1 submenu{{ $submenu['menu_id'] }}" value="{{ $submenu['id'] }}"
onclick="setChecking1({{ $submenu["id"] }})">
</td>
<td class="pull-left">

{{ $submenu['name_sub_menu'] }}
</td>

</tr>
@endif
@endforeach
@endforeach
</tbody>
</table>
</div>
</div>
</div>                              
</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-white border me-2" data-bs-dismiss="modal">Cancel</button>
<button type="submit" class="btn btn-primary">Add User</button>
</div>
</form>

</div>
</div>
<!-- /Company Detail -->

</div>
</div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script type="text/javascript">


$(document).ready(function(){
        $('#selectAll').change(function() {
        $('.permission-checkbox').prop('checked', this.checked);
    });

    // Handle Select All functionality
    $('#selectAll').change(function() {
        $('.permission-checkbox').prop('checked', this.checked).change(); // Trigger change for all checkboxes
    });

    // Handle individual checkbox change
    $('.permission-checkbox').change(function() {
        // Set the value to 1 if checked, otherwise set it to 0
        $(this).val(this.checked ? '1' : '0');

        // Check if all permission checkboxes are checked
        if ($('.permission-checkbox:checked').length === $('.permission-checkbox').length) {
            $('#selectAll').prop('checked', true);
        } else {
            $('#selectAll').prop('checked', false);
        }
    });


var roleId = $("#roleId").val();
if(roleId>0)
{
$("#dec").hide();
}
if(roleId==0)
{
$("#role").val('');
}
$('.select2').select2();
$(".error_message").hide();
$h_menu1=$("#hmenu1").val();
$roleId=$("#roleId").val();
// alert($h_menu1);
setPermison1($roleId,$h_menu1);
});

values=[];
function setChecking1(id) {
get_check_value1(0,id);
}
function setPermison1(roleId,h_menu1){
var h_menu = h_menu1;
var roleId = roleId;  
$("#hmenu1").val('');
$("#roleId").val('');
$("#hmenu1").val(h_menu);
$("#roleId").val(roleId);
$('.chkbox1').prop('checked', false);
var res = h_menu.split(",");
for (i = 0; i < res.length; i++) { 
$("#check1-"+res[i]).prop('checked', true);
values.push(res[i]);
}  
} 
// dhamaadka setuserpermison function
$(document).on("click","#check-all",function(){
if ($(this).is(':checked')){
$('.chkbox1:enabled').prop('checked', true);
$('.allmenuId:enabled').prop('checked', true);
values=[];
}
else{
$('.chkbox1').prop('checked', false);
$('.allmenuId:enabled').prop('checked', false);
values=[];
}
get_check_value1(1,0);
});

$(document).on("click",".allmenuId",function(){
var id = $(this).attr('id');
// var newId =id.slice(id.length - 1);
// var newId = id.split(/\b[\s,\.-:;]*/).length;
var newId = id.replace(/[^0-9\.]/g, '');

console.log(newId);
if ($('#menuId'+newId).is(':checked')){
$(".submenu"+newId).prop('checked', true);
values=[];
}
else{
$('.submenu'+newId).prop('checked', false);
values=[];
}
get_check_value1(1,0);
});
function get_check_value1(flag,id){

if(flag==1){
// console.log(values);
$('.chkbox1:checked').each(function() {
values.push($(this).val());
});
$('#hmenu1').val(values.join(','));
}
if(flag==0){
console.log();
// values = [];
if($('#check1-'+id).is(':checked')){
values.push($('#check1-'+id).val());
$('#hmenu1').val(values.join(','));
}
else{

for(var i in values){
if (values[i]==id){
values.splice(i,1);
break;
}
}

$('#hmenu1').val(values.join(','));
}
}
}
function saveNewRole(){
var role = $("#role").val();
var dec = $("#dec").val();
var menu = $("#hmenu1").val();
var roleId = $("#roleId").val();
var company_id = $("#company_id").val();
var submenue = $('input[name^=submenue]').map(function(idx, elem) {
return $(elem).val();
}).get();
var readpermision = $('input[name^=readpermision]').map(function(idx, elem) {
return $(elem).val();
}).get();
var writepermision = $('input[name^=writepermision]').map(function(idx, elem) {
return $(elem).val();
}).get();

var editpermision = $('input[name^=editpermision]').map(function(idx, elem) {
return $(elem).val();
}).get();
var deletepermision = $('input[name^=deletepermision]').map(function(idx, elem) {
return $(elem).val();
}).get();

if(menu==''){
alert("select At least one");
$('#check-all').focus();
}
else if(role==''){
$('#errRole').text("Require Enter Role");
$("#errRole").focus();
}
else{
// $("#savebtn").prop('disabled', true);
$('.error').hide();
$.post("../../Controller/permission_controller.php", {
role: role,
dec: dec,
roleId:roleId,
company_id:company_id,
menu: menu,
readpermision:readpermision,
writepermision:writepermision,
editpermision:editpermision,
deletepermision:deletepermision,
submenue:submenue
}, function (data, status) {    
console.log(data);
}).done(function(response){
swal({
title:"Good job!",
text:"You have Successfully set permissions!",
type:"success"
});

});
location.assign('user_role.php');
}
}
// set Permison 
// onclick waxaan soo qaadan doonaa usernameka iyo user permissionska uu heesto
// usernameka waxaan u isticmaalaa database table inaan ku pdate kareeyo
// userpermissionska waxaan ku soo bandhigaa check boxka permissinka hada uu uu heysto
function setPermison(userName,h_menu){
var h_menu = h_menu;
var uName = userName;      
$("#hmenu").val(h_menu);
$("#uName").val(uName);
$('.chkbox').prop('checked', false);
var res = h_menu.split(",");
for (i = 0; i < res.length; i++) { 
$("#check-"+res[i]).prop('checked', true);
values.push(res[i]);
}
// console.log(values)   
} // dhamaadka setuserpermison function
// check boxka permissionka ayaan ku tick saaraa dhamaantood onclick ama uga qaadaa
$(document).on("click","#check-all",function(){
if ($(this).is(':checked')){
$('.chkbox:enabled').prop('checked', true);
}
else{
$('.chkbox').prop('checked', false);
values=[];

}
get_check_value(1,0);
});
function get_check_value(flag,id){
if(flag==1){
console.log(values);
$('.chkbox:checked').each(function() {
values.push($(this).val());
});
$('#hmenu').val(values.join(','));
}
if(flag==0){
console.log(values);
// values = [];
if($('#check-'+id).is(':checked')){
values.push($('#check-'+id).val());
$('#hmenu').val(values.join(','));
}
else{

for(var i in values){
if (values[i]==id){
values.splice(i,1);
break;
}
}

$('#hmenu').val(values.join(','));
}
}
}

function setChecking(id) {

get_check_value(0,id);
}

// waxaan halkaan ku sameynay Menue permisions
$(document).on("click",".readAll",function(){
var id = $(this).attr('id');
// var newId =id.slice(id.length - 1);
// var newId = id.split(/\b[\s,\.-:;]*/).length;
var menue_id = id.replace(/[^0-9\.]/g, '');

console.log(menue_id);
if ($('#readAll'+menue_id).is(':checked')){
$(".readsub"+menue_id).prop('checked', true);

$(".readsub"+menue_id).val(1);

}
else{
$('.readsub'+menue_id).prop('checked', false);
$(".readsub"+menue_id).val(0);

}
// get_check_value1(1,0);
});

$(document).on("click",".writeAll",function(){
var id = $(this).attr('id');
// var newId =id.slice(id.length - 1);
// var newId = id.split(/\b[\s,\.-:;]*/).length;
var menue_id = id.replace(/[^0-9\.]/g, '');

console.log(menue_id);
if ($('#writeAll'+menue_id).is(':checked')){
$(".writesub"+menue_id).prop('checked', true);

$(".writesub"+menue_id).val(1);

}
else{
$('.writesub'+menue_id).prop('checked', false);
$(".writesub"+menue_id).val(0);

}
// get_check_value1(1,0);
});

$(document).on("click",".editAll",function(){
var id = $(this).attr('id');
// var newId =id.slice(id.length - 1);
// var newId = id.split(/\b[\s,\.-:;]*/).length;
var menue_id = id.replace(/[^0-9\.]/g, '');

console.log(menue_id);
if ($('#editAll'+menue_id).is(':checked')){
$(".editsub"+menue_id).prop('checked', true);

$(".editsub"+menue_id).val(1);

}
else{
$('.editsub'+menue_id).prop('checked', false);
$(".editsub"+menue_id).val(0);

}
// get_check_value1(1,0);
});

$(document).on("click",".deleteAll",function(){
var id = $(this).attr('id');
// var newId =id.slice(id.length - 1);
// var newId = id.split(/\b[\s,\.-:;]*/).length;
var menue_id = id.replace(/[^0-9\.]/g, '');

console.log(menue_id);
if ($('#deleteAll'+menue_id).is(':checked')){
$(".deletesub"+menue_id).prop('checked', true);

$(".deletesub"+menue_id).val(1);

}
else{
$('.deletesub'+menue_id).prop('checked', false);
$(".deletesub"+menue_id).val(0);

}
// get_check_value1(1,0);
});






function setcheckPermision() {

if ($(this).is(':checked')){
$(this).prop('checked', true);

$(this).val(1);

}
else{
$(this).prop('checked', false);
$(this).val(0);

}
}

</script>
@endsection
