/**
 * Created by nlangloi10 on 5/3/15.
 */

$(document).ready(function () {
    $("div.myOwnAccount").hide();
    $("div.otherAccount").hide();

    $("div.myOwnAccount input").prop('disabled', true);
    $("div.otherAccount input").prop('disabled', true);


    $("input[name=choice]").click(function () {
        if ($(this).val() == "mine") {
            $("div.myOwnAccount").show();
            $("div.otherAccount").hide();

            $("div.myOwnAccount input").prop('disabled', false);
        } else {
            $("div.myOwnAccount").hide();
            $("div.otherAccount").show();

            $("div.otherAccount input").prop('disabled', false);
        }
    });
});