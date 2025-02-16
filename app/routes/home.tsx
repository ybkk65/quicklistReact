import type { Route } from "./+types/home";
import Header from "../components/header/header.tsx";
import Footer from "../components/Footer/Footer";
import logo from "../../public/assets/QuickList-removebg-preview.png"
import {Link} from "react-router-dom";

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
          <div className={"flex justify-center mt-8"}>
              <img className={" h-[120px]"} src={logo} alt="logo"/>
          </div>
          <div className="max-w-6xl mx-auto px-4 py-10 text-center">
              <h1 className="text-4xl font-bold text-green-600 mb-4">Bienvenue sur QuickList</h1>
              <p className="text-lg text-gray-700 mb-6">
                  QuickList est l'application idéale pour créer et gérer vos listes de courses
                  rapidement et facilement. Que vous soyez en train de faire vos courses au supermarché
                  ou de préparer une liste pour un événement spécial, QuickList vous permet de garder
                  une trace de tout ce dont vous avez besoin.
              </p>
              <div className="mt-6">
                  <Link to="/lists/add">
                      <button className="bg-green-600 text-white px-6 py-3 rounded-full hover:bg-green-500 transition">
                          Créez votre première liste
                      </button>
                  </Link>
              </div>
          </div>
          <Footer/>
      </>
  );

}
