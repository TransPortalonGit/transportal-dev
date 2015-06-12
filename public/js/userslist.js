$(function() {

    $('#member_selection').magicSuggest({
        data: ["<?php echo $userslist; ?>"],
        valueField: 'id',
        displayField: 'username'
    });

});