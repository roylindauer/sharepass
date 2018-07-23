namespace :sharepass do 

  desc "run db migrations"
  task :migrate do 
    on roles(:app) do 
      execute "cd -P #{release_path} && php vendor/bin/doctrine-migrations migrations:migrate  --configuration migrations.xml --db-configuration migrations-db-config.php"
    end
  end

  task :rollback do 
    on roles(:app) do 
      execute "cd -P #{release_path} && php vendor/bin/doctrine-migrations  --configuration migrations.xml --db-configuration migrations-db-config.php"
    end
  end

end

after 'deploy:published', 'trap:migrate'
