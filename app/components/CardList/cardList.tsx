import { useState } from "react";
import axios from "axios";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faCheck, faPenToSquare, faTrash } from "@fortawesome/free-solid-svg-icons";

export default function CardList({ shoppingList, onDelete }) {
    const [isDeleting, setIsDeleting] = useState(false);

    // Vérification et parsing des items
    let items = [];
    try {
        items = typeof shoppingList.items === "string" ? JSON.parse(shoppingList.items) : shoppingList.items;
    } catch (error) {
        console.error("Erreur de parsing des items :", error);
    }

    // Formater la date (JJ/MM/AAAA)
    const formattedDate = new Date(shoppingList.created_at).toLocaleDateString("fr-FR");

    const handleDelete = async () => {
        if (isDeleting) return;
        setIsDeleting(true);

        console.log("Tentative de suppression pour l'ID :", shoppingList.id);

        try {
            const response = await axios.delete(`http://127.0.0.1:5556/liste/delete?id=${shoppingList.id}`);

            if (response.status === 201) {
                console.log("Suppression réussie pour l'ID :", shoppingList.id);
                onDelete(shoppingList.id); // Supprime du DOM
            } else {
                console.error("Erreur lors de la suppression, statut :", response.status);
                alert("Problème lors de la suppression.");
            }
        } catch (error) {
            console.error("Erreur réseau ou serveur :", error);
            alert("Erreur réseau, impossible de supprimer.");
        } finally {
            setIsDeleting(false);
        }
    };

    return (
        <div className="bg-gray-100 p-4 rounded-lg shadow-lg w-full sm:w-1/2 lg:w-1/3 xl:w-1/4 mb-4 flex flex-col justify-between">
            <div className="px-4 py-2 flex-grow">
                <div className="flex justify-end gap-2 py-2">
                    <FontAwesomeIcon className="text-orange-400 cursor-pointer" icon={faPenToSquare} />
                    <FontAwesomeIcon
                        className={`text-red-400 cursor-pointer ${isDeleting ? "opacity-50 cursor-not-allowed" : ""}`}
                        icon={faTrash}
                        onClick={handleDelete}
                    />
                </div>
                <h2 className="text-xl font-bold text-green-600 mb-6">{shoppingList.name}</h2>
                <ul>
                    {Array.isArray(items) && items.length > 0 ? (
                        items.map((item, index) => (
                            <li key={index} className="flex items-center space-x-2 mb-2">
                                <span className="px-1 bg-gray-300 rounded hidden">
                                    <FontAwesomeIcon
                                        className={`text-sm font-bold ${item.checked ? "text-green-600" : "text-transparent"}`}
                                        icon={faCheck}
                                    />
                                </span>
                                <span>{item.name} - {item.quantity}</span>
                            </li>
                        ))
                    ) : (
                        <li className="text-gray-500">Aucun article</li>
                    )}
                </ul>
            </div>
            {/* Affichage de la date formatée en bas à droite */}
            <div className="px-4 py-2 flex justify-end text-gray-500 text-sm">
                {formattedDate}
            </div>
        </div>
    );
}
