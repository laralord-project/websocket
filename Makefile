test:
	@set -e; \
	docker compose --env-file=.env.testing -f docker-compose-test.yaml up --build --force-recreate --exit-code-from=test --abort-on-container-exit test; \
	docker compose --env-file=.env.testing -f docker-compose-test.yaml down;
test-interactive:
	docker --env-file=.env.testing compose -f docker-compose.yml -f docker-compose.test.yml run --entrypoint bash test && /
	docker compose -f docker-compose.yml -f docker-compose.test.yml stop database-test
run:
	export DOCKER_BUILDKIT=1 && \
	export COMPOSE_DOCKER_CLI_BUILD=1 && \
 	time docker compose up -d proxy && \
 	$(MAKE) -C  '../way2ocean-service-ui' run && \
 	xdg-open http://service.way2ocean.local > /dev/null
