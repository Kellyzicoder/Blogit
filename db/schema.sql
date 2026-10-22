-- BLOGit database tables (Postgres / Neon).
-- Safe to run more than once: it only creates what is missing.

CREATE TABLE IF NOT EXISTS status (
  statusid   INTEGER PRIMARY KEY,
  statustype VARCHAR(9) NOT NULL
);

INSERT INTO status (statusid, statustype) VALUES
  (1, 'Published'),
  (2, 'Draft')
ON CONFLICT (statusid) DO NOTHING;

-- usertype: 1 = normal user, 2 = admin
CREATE TABLE IF NOT EXISTS users (
  userid    SERIAL PRIMARY KEY,
  firstname VARCHAR(150) NOT NULL,
  lastname  VARCHAR(150) NOT NULL,
  email     VARCHAR(150) NOT NULL UNIQUE,
  password  VARCHAR(120) NOT NULL,
  usertype  INTEGER NOT NULL DEFAULT 1,
  userdate  DATE NOT NULL DEFAULT CURRENT_DATE,
  online    TIMESTAMPTZ
);

-- A "topic" in the app. Deleting a user deletes their topics.
CREATE TABLE IF NOT EXISTS blog (
  blogid     SERIAL PRIMARY KEY,
  bgname     VARCHAR(150) NOT NULL,
  bgdescript VARCHAR(200) NOT NULL DEFAULT '',
  bgdate     DATE NOT NULL,
  userid     INTEGER NOT NULL REFERENCES users(userid) ON DELETE CASCADE
);

-- An entry inside a topic. Deleting a topic deletes its entries.
CREATE TABLE IF NOT EXISTS entry (
  entryid  SERIAL PRIMARY KEY,
  entname  VARCHAR(150) NOT NULL,
  enttext  VARCHAR(2000) NOT NULL DEFAULT '',
  blogid   INTEGER NOT NULL REFERENCES blog(blogid) ON DELETE CASCADE,
  statusid INTEGER NOT NULL REFERENCES status(statusid),
  entdate  DATE NOT NULL
);

CREATE INDEX IF NOT EXISTS blog_userid_idx ON blog(userid);
CREATE INDEX IF NOT EXISTS entry_blogid_idx ON entry(blogid);
CREATE INDEX IF NOT EXISTS entry_statusid_idx ON entry(statusid);
