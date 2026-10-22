import StatusList from "@/components/StatusList";
import type { SearchParams } from "@/lib/params";

export const metadata = { title: "Published | BLOGit" };

export default async function PublishedPage({ searchParams }: { searchParams: SearchParams }) {
  return <StatusList kind="published" sp={await searchParams} />;
}
