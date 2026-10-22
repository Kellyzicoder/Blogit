import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";

export const metadata = { title: "Homepage | Blogit" };

const steps = [
  { img: "1", title: "CREATE A BLOG TOPIC", text: "Decide to create your first blog" },
  {
    img: "2",
    title: "MAKE AN ENTRY",
    text: "Then go ahead and make an entry. When an entry is made, you can either choose to preview, publish or save as draft",
  },
  { img: "3", title: "PREVIEW", text: "You can preview it unto a page to see how it looks." },
  { img: "4", title: "PUBLISH", text: "You can publish it unto a page if you are satisfied." },
  { img: "5", title: "SAVE TO DRAFT", text: "You can save it as draft and edit it later." },
];

export default function HomePage() {
  return (
    <>
      <Navbar links={[{ href: "/community", label: "Community" }]} />

      <header id="showcase">
        <div className="showcase-container">
          <div className="showcase-content">
            <h2>
              WELCOME TO <span id="pagename">BLOG</span>
              <span className="text-secondary">it.</span> WHERE YOU CAN
            </h2>
            <h1 className="l-heading">
              PUBLISH <br />
              YOUR <br />
              PASSION
            </h1>
          </div>
        </div>
      </header>

      <div className="container2">
        <section id="about-us">
          <h2>ABOUT US</h2>
          <p>
            A New Zealand online content management system which enables multi-user blogs with time-stamped entries.
            Google hosts the blogs, which can be accessed by a user anytime, anywhere by using any browswer. Blogit also
            enabled users to publish blogs and save as draft. Blogit has a wide international user base and is available
            in more than 60 languages, despite its decline in popularity in the United States.
            <br />
            <br />
          </p>
        </section>

        <section className="testimonials-content">
          <h2 className="text-primary">OUR TEAM</h2>
          <div className="testimonials">
            <div className="box">
              <img src="/images/Anna-CEO2.png" alt="Anna - CEO" />
              <h3>Anna Mcberth</h3>
              <p>A computer scientist and data manager</p>
            </div>
            <div className="box">
              <img src="/images/Kelvin-CEO1.png" alt="Kelvin - CEO" />
              <h3>Kelvin Mensah - CEO</h3>
              <p>Creator of the backend and frontend</p>
            </div>
            <div className="box">
              <img src="/images/George-CEO3.png" alt="John Doe - CEO" />
              <h3>John Doe</h3>
              <p>A computer scientist and data analyst</p>
            </div>
          </div>
        </section>

        <section>
          <h2 className="text-primary">HOW DOES IT WORK?</h2>
          <div className="howworks">
            <div className="works-content-1">
              {steps.map((s) => (
                <div className="works-box" key={s.img}>
                  <img src={`/images/${s.img}.png`} alt={`Point ${s.img}`} />
                  <p>
                    <span className="text-secondary">{s.title}</span>
                    <br />
                    {s.text}
                  </p>
                </div>
              ))}
            </div>
            <img className="works-content-2" src="/images/Computer.png" alt="Computer picture" />
          </div>
        </section>
      </div>

      <Footer />
    </>
  );
}
