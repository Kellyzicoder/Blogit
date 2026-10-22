export const STATUS = { published: 1, draft: 2 } as const;
export const USER_TYPE = { normal: 1, admin: 2 } as const;

export type User = {
  userid: number;
  firstname: string;
  lastname: string;
  email: string;
  usertype: number;
  userdate: string;
  online: Date | null;
};

export type Topic = {
  blogid: number;
  bgname: string;
  bgdescript: string;
  bgdate: string;
  userid: number;
};

export type Entry = {
  entryid: number;
  entname: string;
  enttext: string;
  blogid: number;
  statusid: number;
  entdate: string;
};

/** An entry joined with its topic and author. */
export type EntryWithTopic = Entry & {
  bgname: string;
  userid: number;
  firstname: string;
  lastname: string;
};

/** Which list the user came from, so "back" and redirects go to the right place. */
export type From = "topic" | "drafts" | "published";
