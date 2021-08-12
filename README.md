# Share Pass

Securely share a password or other private data. 

## Setup

```
docker-compose build
docker-compose up -d
bin/dconsole doctrine:database:create
bin/dconsole doctrine:migrations:migrate 
```

Visit http://localhost:8080


## ISSUES

Symfony is _slow as fuck_ in docker. Goddamn. It's a pain and this app is not even big. 

`composer install` and `composer update` tries to run a git command which hangs. So we are unable to run comoser updates in the container. 

The git command that is failing: `git branch -a --no-color --no-abbrev -v`

My theory is that it's the pager. git branch will load results into a `less` screen which just stinks. So now we have to create a .gitconfig file inside the container to disable the pager functionality. 

