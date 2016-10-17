CREATE TABLE answers (id BIGINT AUTO_INCREMENT, task_id BIGINT NOT NULL, name VARCHAR(64) NOT NULL, info VARCHAR(32) NOT NULL, value VARCHAR(32) NOT NULL, team_id BIGINT, UNIQUE INDEX ui_task_value_idx (task_id, value), INDEX task_id_idx (task_id), INDEX team_id_idx (team_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE games (id BIGINT AUTO_INCREMENT, name VARCHAR(255) NOT NULL, short_info TEXT NOT NULL, short_info_enabled TINYINT(1) DEFAULT '0' NOT NULL, description LONGTEXT NOT NULL, team_id BIGINT, team_name_backup VARCHAR(255), region_id BIGINT, start_briefing_datetime datetime NOT NULL, start_datetime datetime NOT NULL, stop_datetime datetime NOT NULL, finish_briefing_datetime datetime NOT NULL, time_per_game BIGINT DEFAULT 540 NOT NULL, time_per_task BIGINT DEFAULT 90 NOT NULL, time_per_tip BIGINT DEFAULT 30 NOT NULL, try_count BIGINT DEFAULT 10 NOT NULL, update_interval BIGINT DEFAULT 5 NOT NULL, teams_can_update TINYINT(1) DEFAULT '0' NOT NULL, update_interval_max BIGINT DEFAULT 600 NOT NULL, task_define_default_name VARCHAR(32) DEFAULT 'Загадка' NOT NULL, task_tip_prefix VARCHAR(32) DEFAULT 'Подсказка' NOT NULL, status BIGINT DEFAULT 0 NOT NULL, started_at BIGINT NOT NULL, finished_at BIGINT NOT NULL, game_last_update BIGINT NOT NULL, INDEX team_id_idx (team_id), INDEX region_id_idx (region_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE game_candidates (id BIGINT AUTO_INCREMENT, team_id BIGINT NOT NULL, game_id BIGINT NOT NULL, UNIQUE INDEX ui_team_game_idx (team_id, game_id), INDEX team_id_idx (team_id), INDEX game_id_idx (game_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE game_create_requests (id BIGINT AUTO_INCREMENT, team_id BIGINT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, tag VARCHAR(32), INDEX team_id_idx (team_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE granted_permissions (id BIGINT AUTO_INCREMENT, web_user_id BIGINT NOT NULL, permission_id BIGINT DEFAULT 0 NOT NULL, filter_id BIGINT DEFAULT 0 NOT NULL, deny TINYINT(1) DEFAULT '0' NOT NULL, UNIQUE INDEX ui_webuser_permission_filter_idx (web_user_id, permission_id, filter_id), INDEX web_user_id_idx (web_user_id), INDEX permission_id_idx (permission_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE permissions (id BIGINT AUTO_INCREMENT, description VARCHAR(255), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE posted_answers (id BIGINT AUTO_INCREMENT, task_state_id BIGINT NOT NULL, value VARCHAR(64) NOT NULL, post_time BIGINT NOT NULL, web_user_id BIGINT, answer_id BIGINT, status BIGINT DEFAULT 0 NOT NULL, UNIQUE INDEX ui_state_value_idx (task_state_id, value), INDEX task_state_id_idx (task_state_id), INDEX answer_id_idx (answer_id), INDEX web_user_id_idx (web_user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE regions (id BIGINT AUTO_INCREMENT, name VARCHAR(32) DEFAULT '(Новый проект)' NOT NULL, UNIQUE INDEX ui_state_value_idx (id, name), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE system_settings (id BIGINT, fast_user_register TINYINT(1) DEFAULT '0' NOT NULL, fast_team_create TINYINT(1) DEFAULT '0' NOT NULL, email_team_create TINYINT(1) DEFAULT '1' NOT NULL, email_game_create TINYINT(1) DEFAULT '0' NOT NULL, PRIMARY KEY(id) ENGINE = INNODB;
CREATE TABLE tasks (id BIGINT AUTO_INCREMENT, name VARCHAR(32) NOT NULL, public_name VARCHAR(255) NOT NULL, time_per_task_local BIGINT DEFAULT 0 NOT NULL, manual_start TINYINT(1) DEFAULT '0' NOT NULL, try_count_local BIGINT DEFAULT 0 NOT NULL, priority_free BIGINT DEFAULT 0 NOT NULL, priority_queued BIGINT DEFAULT -10 NOT NULL, priority_busy BIGINT DEFAULT 0 NOT NULL, priority_filled BIGINT DEFAULT -500 NOT NULL, priority_per_team BIGINT DEFAULT -10 NOT NULL, max_teams BIGINT DEFAULT 0 NOT NULL, locked TINYINT(1) DEFAULT '0' NOT NULL, min_answers_to_success BIGINT DEFAULT 0 NOT NULL, game_id BIGINT NOT NULL, INDEX game_id_idx (game_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE task_constraints (id BIGINT AUTO_INCREMENT, task_id BIGINT NOT NULL, target_task_id BIGINT DEFAULT 0 NOT NULL, priority_shift BIGINT DEFAULT 0 NOT NULL, UNIQUE INDEX ui_task_target_task_idx (task_id, target_task_id), INDEX task_id_idx (task_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE task_states (id BIGINT AUTO_INCREMENT, team_state_id BIGINT NOT NULL, task_id BIGINT NOT NULL, given_at BIGINT NOT NULL, started_at BIGINT DEFAULT 0 NOT NULL, accepted_at BIGINT DEFAULT 0 NOT NULL, task_idle_time BIGINT DEFAULT 0 NOT NULL, done_at BIGINT DEFAULT 0 NOT NULL, task_time_spent BIGINT DEFAULT 0 NOT NULL, closed TINYINT(1) DEFAULT '0' NOT NULL, status BIGINT DEFAULT 0 NOT NULL, task_last_update BIGINT NOT NULL, UNIQUE INDEX ui_team_state_task_idx (team_state_id, task_id), INDEX team_state_id_idx (team_state_id), INDEX task_id_idx (task_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE task_transitions (id BIGINT AUTO_INCREMENT, task_id BIGINT NOT NULL, target_task_id BIGINT DEFAULT 0 NOT NULL, allow_on_success TINYINT(1) DEFAULT '1' NOT NULL, allow_on_fail TINYINT(1) DEFAULT '1' NOT NULL, manual_selection TINYINT(1) DEFAULT '0' NOT NULL, UNIQUE INDEX ui_task_target_task_idx (task_id, target_task_id), INDEX task_id_idx (task_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE teams (id BIGINT AUTO_INCREMENT, name VARCHAR(32) NOT NULL, full_name VARCHAR(255), region_id BIGINT, INDEX region_id_idx (region_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE team_candidates (id BIGINT AUTO_INCREMENT, web_user_id BIGINT NOT NULL, team_id BIGINT DEFAULT 0 NOT NULL, UNIQUE INDEX ui_webuser_team_idx (web_user_id, team_id), INDEX web_user_id_idx (web_user_id), INDEX team_id_idx (team_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE team_create_requests (id BIGINT AUTO_INCREMENT, web_user_id BIGINT NOT NULL, name VARCHAR(32) NOT NULL, full_name VARCHAR(255), description VARCHAR(255) NOT NULL, tag VARCHAR(32), INDEX web_user_id_idx (web_user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE team_players (id BIGINT AUTO_INCREMENT, web_user_id BIGINT NOT NULL, team_id BIGINT DEFAULT 0 NOT NULL, is_leader TINYINT(1) DEFAULT '0' NOT NULL, UNIQUE INDEX ui_webuser_team_idx (web_user_id, team_id), INDEX web_user_id_idx (web_user_id), INDEX team_id_idx (team_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE team_states (id BIGINT AUTO_INCREMENT, team_id BIGINT NOT NULL, game_id BIGINT NOT NULL, start_delay BIGINT DEFAULT 0 NOT NULL, ai_enabled TINYINT(1) DEFAULT '1' NOT NULL, started_at BIGINT DEFAULT 0 NOT NULL, finished_at BIGINT DEFAULT 0 NOT NULL, status BIGINT DEFAULT 0 NOT NULL, task_id BIGINT, team_last_update BIGINT NOT NULL, UNIQUE INDEX ui_team_game_idx (team_id, game_id), INDEX team_id_idx (team_id), INDEX game_id_idx (game_id), INDEX task_id_idx (task_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE tips (id BIGINT AUTO_INCREMENT, task_id BIGINT NOT NULL, name VARCHAR(64) NOT NULL, define LONGTEXT NOT NULL, delay BIGINT DEFAULT 0 NOT NULL, answer_id BIGINT, INDEX task_id_idx (task_id), INDEX answer_id_idx (answer_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE used_tips (id BIGINT AUTO_INCREMENT, task_state_id BIGINT NOT NULL, tip_id BIGINT NOT NULL, status BIGINT DEFAULT 0 NOT NULL, used_since BIGINT NOT NULL, UNIQUE INDEX ui_state_tip_idx (task_state_id, tip_id), INDEX task_state_id_idx (task_state_id), INDEX tip_id_idx (tip_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE web_users (id BIGINT AUTO_INCREMENT, login VARCHAR(32) NOT NULL, pwd_hash VARCHAR(32) NOT NULL, full_name VARCHAR(255), region_id BIGINT, email VARCHAR(255) NOT NULL, tag VARCHAR(32), is_enabled TINYINT(1) DEFAULT '0' NOT NULL, INDEX region_id_idx (region_id), PRIMARY KEY(id)) ENGINE = INNODB;
ALTER TABLE answers ADD CONSTRAINT answers_team_id_teams_id FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE;
ALTER TABLE answers ADD CONSTRAINT answers_task_id_tasks_id FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE;
ALTER TABLE games ADD CONSTRAINT games_team_id_teams_id FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE SET NULL;
ALTER TABLE games ADD CONSTRAINT games_region_id_regions_id FOREIGN KEY (region_id) REFERENCES regions(id) ON DELETE SET NULL;
ALTER TABLE game_candidates ADD CONSTRAINT game_candidates_team_id_teams_id FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE;
ALTER TABLE game_candidates ADD CONSTRAINT game_candidates_game_id_games_id FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE;
ALTER TABLE game_create_requests ADD CONSTRAINT game_create_requests_team_id_teams_id FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE;
ALTER TABLE granted_permissions ADD CONSTRAINT granted_permissions_web_user_id_web_users_id FOREIGN KEY (web_user_id) REFERENCES web_users(id) ON DELETE CASCADE;
ALTER TABLE granted_permissions ADD CONSTRAINT granted_permissions_permission_id_permissions_id FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE;
ALTER TABLE posted_answers ADD CONSTRAINT posted_answers_web_user_id_web_users_id FOREIGN KEY (web_user_id) REFERENCES web_users(id) ON DELETE SET NULL;
ALTER TABLE posted_answers ADD CONSTRAINT posted_answers_task_state_id_task_states_id FOREIGN KEY (task_state_id) REFERENCES task_states(id) ON DELETE CASCADE;
ALTER TABLE posted_answers ADD CONSTRAINT posted_answers_answer_id_answers_id FOREIGN KEY (answer_id) REFERENCES answers(id) ON DELETE SET NULL;
ALTER TABLE tasks ADD CONSTRAINT tasks_game_id_games_id FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE;
ALTER TABLE task_constraints ADD CONSTRAINT task_constraints_task_id_tasks_id FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE;
ALTER TABLE task_states ADD CONSTRAINT task_states_team_state_id_team_states_id FOREIGN KEY (team_state_id) REFERENCES team_states(id) ON DELETE CASCADE;
ALTER TABLE task_states ADD CONSTRAINT task_states_task_id_tasks_id FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE;
ALTER TABLE task_transitions ADD CONSTRAINT task_transitions_task_id_tasks_id FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE;
ALTER TABLE teams ADD CONSTRAINT teams_region_id_regions_id FOREIGN KEY (region_id) REFERENCES regions(id) ON DELETE SET NULL;
ALTER TABLE team_candidates ADD CONSTRAINT team_candidates_web_user_id_web_users_id FOREIGN KEY (web_user_id) REFERENCES web_users(id) ON DELETE CASCADE;
ALTER TABLE team_candidates ADD CONSTRAINT team_candidates_team_id_teams_id FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE;
ALTER TABLE team_create_requests ADD CONSTRAINT team_create_requests_web_user_id_web_users_id FOREIGN KEY (web_user_id) REFERENCES web_users(id) ON DELETE CASCADE;
ALTER TABLE team_players ADD CONSTRAINT team_players_web_user_id_web_users_id FOREIGN KEY (web_user_id) REFERENCES web_users(id) ON DELETE CASCADE;
ALTER TABLE team_players ADD CONSTRAINT team_players_team_id_teams_id FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE;
ALTER TABLE team_states ADD CONSTRAINT team_states_team_id_teams_id FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE;
ALTER TABLE team_states ADD CONSTRAINT team_states_task_id_tasks_id FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE SET NULL;
ALTER TABLE team_states ADD CONSTRAINT team_states_game_id_games_id FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE;
ALTER TABLE tips ADD CONSTRAINT tips_task_id_tasks_id FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE;
ALTER TABLE tips ADD CONSTRAINT tips_answer_id_answers_id FOREIGN KEY (answer_id) REFERENCES answers(id) ON DELETE SET NULL;
ALTER TABLE used_tips ADD CONSTRAINT used_tips_tip_id_tips_id FOREIGN KEY (tip_id) REFERENCES tips(id) ON DELETE CASCADE;
ALTER TABLE used_tips ADD CONSTRAINT used_tips_task_state_id_task_states_id FOREIGN KEY (task_state_id) REFERENCES task_states(id) ON DELETE CASCADE;
ALTER TABLE web_users ADD CONSTRAINT web_users_region_id_regions_id FOREIGN KEY (region_id) REFERENCES regions(id) ON DELETE SET NULL;
