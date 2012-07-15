<h1>Auth With FB</h1>
<html>
    <body>
        <form action="{$smarty.get.redirect_uri}" method="get">
            <select name="auth_result">
                <option value="authed">Authed: Test User</option>
                <option value="notauthed">Not Authed</option>
                <option value="rejected">Reject App (not implemented)</option>
            </select>

            <input type="submit" />

        </form>
    </body>
</html>
