# Wallet Pivot

Why change from one provider to other are so difficult?

## Your secrets ARE yours

Changing from one wallet or vault provider should be simple, but it isn't.

From March 2021, [LastPass made a change](https://blog.lastpass.com/2021/02/changes-to-lastpass-free/) on its contracts and service offer, limiting to 1 device type (mobile or desktop) sync. That change impact a lot of people, specially thats living on countries with a weak currency, me included.

After try the process to migrate from LastPass, first to KeePassXC and later to BitWarden and noticing some data are lost (attachments and files) while other are messy (notes and Server item type) I found the best solution is to implement a custom utility to move the secrets from and to different providers.

## Using

You will need a shell, `PHP 8+`, `composer` and the CLI from your adapter.

### CLI Adapters

Currently supported adapters are:

 - LastPass: [Install](https://github.com/lastpass/lastpass-cli#lastpass-cli) | [Usage](https://lastpass.github.io/lastpass-cli/lpass.1.html#_examples)
 - BitWarden: [Install](https://bitwarden.com/help/article/cli/#download-and-install) | [Usage](https://bitwarden.com/help/article/cli/)

You need at least two of them to migrate your secrets between each other.

## FAQ

### Why I need to install a CLI of X?

When a started think about how to migrate my secrets from one provider to other I noticed they both provide a _cli_ version. It is a case of common denominator.

### Why PHP?

[Why not?](https://www.php.net/releases/8.0/en.php)

### Help, I have milions of secrets

I made the decision to load all secrets at once and store it on memory, so I can transform and detect problems easily. That decision imply you need so much RAM as you have more secrets.