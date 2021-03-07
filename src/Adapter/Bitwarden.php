<?php
declare(strict_types=1);

namespace WalletPivot\Adapter;

/**
 * Adapter to interact with BitWarden CLI (https://bitwarden.com/help/article/cli/)
 */
class BitWarden extends Adapter
{
    protected string $exec = 'bw';

    /**
     * Init a session with CLI command.
     * Store session token to next actions
     *
     * @param  string $user Username to unlock your vault
     * @param  string $pass Password to unlock your vault
     * @return void
     */
    public function login($user, $pass): void
    {
        $token = $this->call("login '{$user}' '{$pass}'", false);

        $this->token = $token;
    }

    /**
     * Load all saved secrets on memory to compute
     * easily what need update
     *
     * @return array List of secrets
     */
    public function load(): array
    {
        $secrets = $this->call("list");
        $this->secrets = [];

        foreach ($secrets as $secret) {
            $s = new Secret();
            $s->title = $secret->title;
            $s->dirty = false;

            $this->secrets[$secret->title] = $s;
        }
    }

    /**
     * Save (create or update) a entry into the adapter
     *
     * @param  \WalletPivot\Secret $secret Instance of a secret with its data
     * @throws \WalletPivot\Adapter\Exception\PersistException If adapter reject for any reason
     * @return void
     */
    public function save(Secret $secret): void
    {
    }

    /**
     * Custom way to insert session token into $cmd when interact
     * with adapter CLI
     *
     * @param  string $cmd Actual command string
     * @return String      Command with token parameter
     */
    protected function insertToken(string $cmd): string
    {
        if (strpos($cmd, '--session') === false) {
            $cmd .= " --session {$this->token}";
        }

        return $cmd;
    }
}