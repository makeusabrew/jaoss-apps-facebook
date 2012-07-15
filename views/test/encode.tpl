<form action="{$full_url}" method="post">
    <textarea rows=20 cols=40 name="data" placeholder="paste some JSON in here">{if isset($smarty.post.data)}{$smarty.post.data}{/if}</textarea>

    <input type=submit />
</form>

{if isset($signed_request)}
    <p>Signed Request: <pre>{$signed_request}</pre></p>

    {if isset($bad_request)}
        <p>This request does not decode - it is invalid.</p>
    {else}
        <p>Which decodes back to:</p>
        <div>
            {$decoded_request|@var_dump}
        </div>
    {/if}
{/if}
