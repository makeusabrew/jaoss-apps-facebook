<h1>Auth With FB</h1>
<html>
    <body>
        <form action="{$smarty.get.redirect_uri}" method="get">
            <select name="auth_result">
                <option value="authed">Authed: Test User</option>
                <option value="notauthed">Not Authed</option>
            </select>

            <input type="submit" />

        </form>

        <a href="">Reject app</a>
    </body>
</html>
