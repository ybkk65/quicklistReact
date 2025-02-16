import { useState } from "react";
import axios from "axios";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faPenToSquare, faTrash } from "@fortawesome/free-solid-svg-icons";
import { useNavigate } from "react-router-dom";
import DeleteConfirmation from "../ConfirmationMessage/ConfirmationMessage";

export default function CardList({ shoppingList, onDelete }) {
    const [isDeleting, setIsDeleting] = useState(false);
    const [showConfirmation, setShowConfirmation] = useState(false);
    const navigate = useNavigate();

    let items = [];
    try {
        items = typeof shoppingList.items === "string" ? JSON.parse(shoppingList.items) : shoppingList.items;
    } catch (error) {
        console.error("Erreur de parsing des items :", error);
    }

    const formattedDate = new Date(shoppingList.created_at).toLocaleDateString("fr-FR");

    const handleEdit = () => {
        navigate(`/lists/update/${shoppingList.id}`);
    };

    const handleDelete = async () => {
        setIsDeleting(true);

        try {
            const response = await axios.delete("http://127.0.0.1:5556/liste/delete", {
                params: { id: shoppingList.id }
            });

            if (response.status === 200) {
                onDelete(shoppingList.id);
            }
        } catch (error) {
            console.error("Erreur lors de la suppression :", error);
            alert("Impossible de supprimer l'élément.");
        } finally {
            setIsDeleting(false);
            setShowConfirmation(false);
        }
    };

    return (
        <div className="bg-gray-100 p-4 rounded-lg shadow-lg w-full sm:w-1/2 lg:w-1/3 xl:w-1/4 mb-4 flex flex-col justify-between">
            <div className="px-4 py-2 flex-grow">
                <div className="flex justify-end gap-2 py-2">
                    <FontAwesomeIcon
                        className="text-orange-400 cursor-pointer"
                        icon={faPenToSquare}
                        onClick={handleEdit}
                    />
                    <FontAwesomeIcon
                        className={`text-red-400 cursor-pointer ${isDeleting ? "opacity-50 cursor-not-allowed" : ""}`}
                        icon={faTrash}
                        onClick={() => setShowConfirmation(true)}
                    />
                </div>
                <h2 className="text-xl font-bold text-green-600 mb-6">{shoppingList.name}</h2>
                <ul>
                    {Array.isArray(items) && items.length > 0 ? (
                        items.map((item, index) => (
                            <li key={index} className="flex items-center space-x-2 mb-2">
                                <span>{item.name} - {item.quantity}</span>
                            </li>
                        ))
                    ) : (
                        <li className="text-gray-500">Aucun article</li>
                    )}
                </ul>
            </div>
            <div className="px-4 py-2 flex justify-end text-gray-500 text-sm">
                {formattedDate}
            </div>

            {showConfirmation && <DeleteConfirmation onConfirm={handleDelete} onCancel={() => setShowConfirmation(false)} />}
        </div>
    );
}
