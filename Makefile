FORCE:

all:        css

css:        FORCE
			@echo -n Building css ..
			@cat    ./public/css/src/*.min.css                          \
					> ./public/css/dist/app.min.css
			@echo . Done

merge:
			@echo Merging branch develop to master ...
			@git checkout master
			@git merge develop
			@git push origin master
			@git checkout develop
			@echo Develop merged with master