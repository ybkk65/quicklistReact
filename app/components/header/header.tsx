import { Link } from "react-router-dom";
import Logo from "../../../public/assets/QuickList-removebg-preview.png";

export default function Header() {
    return (
        <nav className="bg-green-600 p-2 shadow-md">
            <div className="max-w-6xl mx-auto px-4 flex items-center gap-[100px]">
                <div>
                    <img className="h-18 w-auto" src={Logo} alt="QuickList Logo" />
                </div>
                <div>
                    <ul className="flex space-x-6 text-white font-semibold">
                        <li className="hover:text-green-300 cursor-pointer">
                            <Link to="/lists/all">Vos Listes</Link>
                        </li>
                        <li className="hover:text-green-300 cursor-pointer">
                            <Link to="/lists/add">Nouvelle Liste</Link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    );
}
