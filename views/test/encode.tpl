<form action="{$full_url}" method="post">
    <textarea rows=20 cols=40 name="data" placeholder="paste some JSON in here"></textarea>

    <input type=submit />
</form>

{if isset($signed_request)}
    <p>Signed Request: <pre>{$signed_request}</pre></p>

    <p>Which decodes back to:</p>
    <div>
        {$decoded_request|@var_dump}
    </div>
{/if}
