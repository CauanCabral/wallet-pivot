<?php
declare(strict_types=1);

namespace WalletPivot\Adapter;

/**
 * Define a abstract class/interface to act with
 * external Wallets throught their CLI
 */
abstract class Adapter
{
    /**
     * Command name
     */
    protected string $exec;

    /**
     * Session token to interact with vault
     */
    protected string $token;

    /**
     * List of Secret inside your vault
     */
    protected array $secrets;

    /**
     * Define manually an access token
     *
     * @param string $token Value to store as session
     * token.
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * Init a session with CLI command.
     * Store session token to next actions
     *
     * @param  string $user Username to unlock your vault
     * @param  string $pass Password to unlock your vault
     * @return void
     */
    abstract public function login(string $user, string $pass): void;

    /**
     * Load all saved secrets on memory to compute
     * easily what need update
     *
     * @return array List of secrets
     * @return void
     */
    abstract public function load(): array;

    /**
     * Save (create or update) a entry into the adapter
     *
     * @param  \WalletPivot\Secret $secret Instance of a secret with its data
     * @throws \WalletPivot\Adapter\Exception\PersistException If adapter reject for any reason
     * @return void
     */
    abstract public function save(Secret $secret): void;

    /**
     * Custom way to insert session token into $cmd when interact
     * with adapter CLI
     *
     * @param  string $cmd Actual command string
     * @return String      Command with token parameter
     */
    abstract protected function insertToken(string $cmd): string;

    /**
     * Internal method to interact with CLI
     *
     * @param  string $cmd Subcommand and parameters
     * @return mixed
     */
    protected function call(string $cmd, bool $auth = true): mixed
    {
        $prepend = "{$this->exec}";
        if ($auth) {
            if ($this->token === null) {
                throw new RuntimeException('You should call login method or set a token first.');
            }

            $prepend = $this->insertToken($prepend);
        }

        $cmd = "{$prepend} {$cmd}";

        $retOut = [];
        $retVal = 0;
        exec($cmd, $retOut, $retVal);

        if ($retVal !== 0) {
            $retOut = implode("\n", $retOut);
            throw new RuntimeException("Error running '{$cmd}'. \n{$retOut}.");
        }

        return json_decode($retOut);
    }
}