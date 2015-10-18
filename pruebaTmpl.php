<!DOCTYPE html>
<html>
<head>
<title>JQuery Template / {{each}}</title>
<script src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/jquery.tmpl.min.js"></script>
<script type="text/javascript">
var data = [
{name: "victor", middlename: "herrera", lastname: "coronado", phones:["1111111","222222","333333","44444"]},
{name: "test", middlename: "btest", lastname: "ctest", phones:["23423423","9999999","8484888","010101010"]},
{name: "paco", middlename: "xxxxa", lastname: "yyyyyy", phones:["02309203909","999999","111113","0909090909"]}
];
$(function(){
$('#myTmpl').tmpl(data).appendTo('#results');
});
</script>
</head>
<body>
<h1>JQuery Template / {{each}}</h1>
<table>
<thead>
<tr>
<th>Name</th>
<th>Middle Name</th>
<th>Last Name</th>
<th>Phones</th>
</tr>
</thead>
<tbody id="results">
</tbody>
</table>
<!-- Template -->
<script id="myTmpl" type="text/x-jquery-tmpl">
<tr>
<td>${name}</td>
<td>${middlename}</td>
<td>${lastname}</td>
<td>
{{each(i,item) phones}}
Phone ${i}: ${item} <br/>
{{/each}}
</td>
</tr>
</script>
</body>
</html>
