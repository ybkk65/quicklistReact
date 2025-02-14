import type { Route } from "./+types/home";
import Header from "../components/header/header.tsx";

export function meta({}: Route.MetaArgs) {
  return [
    { title: "New React Router App" },
    { name: "description", content: "Welcome to React Router!" },
  ];
}

export default function Home() {
  return(
      <>
        <Header />

      </>
  );

}
