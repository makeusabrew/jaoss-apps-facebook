User authed?
{if $user->isAuthed()}
    Yes
{else}
    No
{/if}

{if isset($authUrl)}
    Auth Url: <a target="top" href="{$authUrl}">{$authUrl}</a>
{/if}
