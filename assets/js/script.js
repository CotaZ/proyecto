$(document).ready(function() {
    $("#voteForm").submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "includes/submit_vote.php",
            data: formData,
            success: function(response) {
                $("#result").html(response);
            }
        });
    });

    $("#region").change(function() {
        var regionId = $(this).val();
        $.ajax({
            url: "includes/get_comunas.php",
            type: "GET",
            data: { region_id: regionId },
            success: function(data) {
                $("#comuna").html(data);
            }
        });
    });

    $("#comuna").change(function() {
        var comunaId = $(this).val();
        $.ajax({
            url: "includes/get_candidatos.php",
            type: "GET",
            data: { comuna_id: comunaId },
            success: function(data) {
                $("#candidato").html(data);
            }
        });
    });
});