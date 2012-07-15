<html>
    <body>
        <form action="{$base_href}" target="iframe" method="post">
            <select name="signed_request">
                <option value="" disabled>GET</option>
                <option value="">No signed request</option>
                <optgroup label="Signed Request">
                    <option value="authed">Test User</option>
                    <option value="exception">Trigger exception from FB graph</option>
                    <option value="notauthed">Not Authed</option>
                </optgroup>
            </select>

            <input type="submit" />

        </form>

        <iframe src="{$base_href}" name="iframe" style="width:810px;height:800px;"></iframe>

        {if isset($smarty.get.auth_result)}
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
            <script>
                $("form select").val("{$smarty.get.auth_result}");
                $("form").submit();
            </script>
        {/if}
    </body>
</html>
