# BD Migrations

This library contains the ActiveRecord migrations used for SumUp database changes.

## Installation

There are at least two ways to do that:

1. Clone the code and run:

```
    bundle install
```

2. Use the Jenkins job for that:

[DBMigrate-RUBY-2.1] (https://jenkins.internal.sumup.com/job/DBMigrate-RUBY-2.1/)
    
This job will make an rpm package for a selected branch,
and then install it on the selected dev server and run the migrations.

## Usage

- Db Migrations uses rake for running operations (rake configs are in lib/tasks/*.rake).
- You can see all available operations with the command:

```
[sumup@server-dev dbmigrate-sumup]$ bundle exec rake -T
rake db:create                # Create a database
rake db:create_from_template  # [POSTGRES] Create a database as a copy of an existing database on the same server (TEMPLATE_DB)
rake db:drop                  # Drop a database
rake db:forward               # Forwards next <STEPS> migrations
rake db:migrate               # Run database migrations
rake db:migrate:down          # Runs the "down" for a given migration VERSION
rake db:migrate:redo          # Rollbacks the database one migration and re migrate up (options: STEP=x, VERSION=x)
rake db:migrate:reset         # Resets your database using your migrations for the current environment
rake db:migrate:status        # Display status of migrations
rake db:migrate:up            # Runs the "up" for a given migration VERSION
rake db:populate:fake_data    # Populate database with fake data
rake db:rollback              # Rollback last <STEPS> migrations
rake db:schema:dump           # Create a db/schema.rb file that can be portably used against any DB supported by AR
rake db:schema:load           # Load a schema.rb file into the database
rake db:test:prepare          # Re-create the test db, by copying a template one (if TEMPLATE_DB is specified) or by running all migrations
rake db:truncate              # Truncate all tables
rake generate:migration       # Create a new migration, requires a MIGRATION_NAME (or NAME, MIGRATION) parameter
```

- Because all dependency libraries are bundled please add "bundle exec" to all commands.
- The most used operations are "bundle exec rake db:migrate" and "bundle exec rake db:rollback".
- You can see the available and ran already migrations with "bundle exec rake db:migrate:status".

- Migrations are placed in "db/migrte" directory.
- Database configurations file is "config/database.yml".
- Default environment can be set in file "config/env".
- If you are not using the default environment from "config/env",
  you can write "RAILS_ENV=<environment> " as prefix for each command.
