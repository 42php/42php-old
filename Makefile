FORCE:

all:        css

css:        FORCE
			@echo -n Building css ..
			@cat    ./public/css/src/*.min.css                          \
					> ./public/css/dist/app.min.css
			@echo . Done