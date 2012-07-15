<p>
    User authed?
    {if $user->isAuthed()}
        Yes
    {else}
        No
    {/if}
</p>

{if $user->isAuthed()}
    <p>Facebook ID: {$user->getId()}</p>
    <p>Forename: {$user->forename}</p>
    <p>Surname: {$user->surname}</p>
{/if}

{if isset($authUrl)}
    <p>
        Auth Url: <a target="top" href="{$authUrl}">{$authUrl}</a>
    </p>
{/if}
