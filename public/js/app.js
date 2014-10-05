$(document).ready(function ()
{
	$("#form_submit").click(function ()
	{
		$("#target_form").submit();
	});

	$(".delete_group").click(function()
	{
		$("#btn_delete_group").prop('href', '/forum/group/' + event.target.id + '/delete');
	});
});