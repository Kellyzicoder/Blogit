import Form from "next/form";

/**
 * The small edit/delete icon on each row. It is a form (not a link) because
 * the old stylesheet styles each row's forms by their position.
 * It just opens `action` with the hidden values in the URL (like ?edit=5).
 */
export default function IconButton({
  action,
  hidden,
  icon,
  title,
}: {
  action: string;
  hidden: Record<string, string | number>;
  icon: "edit" | "delete";
  title: string;
}) {
  return (
    <Form action={action} scroll={false}>
      {Object.entries(hidden).map(([k, v]) => (
        <input key={k} type="hidden" name={k} value={v} />
      ))}
      <button type="submit" className="iconbtn" title={title} aria-label={title}>
        <img src={icon === "edit" ? "/images/edit.png" : "/images/delete-16.png"} alt="" />
      </button>
    </Form>
  );
}
