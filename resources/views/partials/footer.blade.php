<footer class="bg-light text-center text-lg-start" style="margin-top: 50px;">
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2020 Copyright:
        <a class="text-dark" href="https://mdbootstrap.com/">MDBootstrap.com</a>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
        integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<script>
    $(function () {

        var today = new Date();

        $('select').selectize({
            sortField: 'text'
        });

        $("#start_date").datepicker({
            dateFormat: "yy-mm-dd",
            maxDate: today
        });
        $("#end_date").datepicker({
            dateFormat: "yy-mm-dd",
            maxDate: today
        });

    });

    $(document).ready(function () {
        $("#start_date, #end_date").datepicker();

        $("#add-post-form").submit(function (e) {
            e.preventDefault();

            var startDate = $("#start_date").val();
            var endDate = $("#end_date").val();

            if (startDate > endDate) {
                $("#date_error").show();
            } else {
                $("#date_error").hide();
                $(this).unbind('submit').submit(); // Unbind the submit event and submit the form
            }
        });
    });

</script>
