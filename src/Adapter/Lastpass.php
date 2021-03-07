<?php
declare(strict_types=1);

namespace WalletPivot\Adapter;

/**
 * Adapter to interact with LastPass CLI (https://github.com/lastpass/lastpass-cli)
 */
class LastPass extends Adapter
{
    protected string $exec = 'lp';
}