# Sulu ES CQRS

This repository implements a "different" content-module. It is used to collect different ideas for future content-store.

Following features will be tested here:

* Event-Sourcing for pages/excerpt/seo
* CQRS for managing a view (doctrine-entity) and a write-model (events)
* Content-Types
  * Scalar (string, int, date, json_serializable)
  * Reference (single and multiple)
  
## TODO

- [ ] Content management

  - [x] Translations
  - [ ] Ghost
  - [ ] Shadow
  - [ ] Content Types
    * Scalar
    * Reference
  - [ ] Excerpts
  - [ ] Tree
  - [ ] Versions
  - [ ] Draftings
  
- [ ] Snippets
- [ ] Articles
- [ ] ...

## Installation

__Mac:__

```
rm -rf var/cache/*
rm -rf var/logs/*
rm -rf var/sessions/*
HTTPDUSER=`ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
sudo chmod +a "$HTTPDUSER allow delete,write,append,file_inherit,directory_inherit" var/cache var/logs var/uploads var/uploads/* web/uploads web/uploads/* var/indexes var/sessions
sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" var/cache var/logs var/uploads var/uploads/* web/uploads web/uploads/* var/indexes var/sessions
```

__Linux:__

```
rm -rf var/cache/*
rm -rf var/logs/*
rm -rf var/sessions/*
HTTPDUSER=`ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX var/cache var/logs var/uploads var/uploads/* web/uploads web/uploads/* var/indexes var/sessions
sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX var/cache var/logs var/uploads var/uploads/* web/uploads web/uploads/* var/indexes var/sessions
```
