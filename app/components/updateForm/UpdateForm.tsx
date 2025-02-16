import React, { useEffect, useState } from "react";
import {Link, useParams} from "react-router-dom";
import axios from "axios";
import Message from "../Message/Message";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faPenToSquare, faSquarePlus, faX } from "@fortawesome/free-solid-svg-icons";

const UpdateForm = () => {
    const { id } = useParams();
    const [listName, setListName] = useState("");
    const [items, setItems] = useState<{ name: string; quantity: number }[]>([]);
    const [newItem, setNewItem] = useState<{ name: string; quantity: number }>({ name: "", quantity: 0 });
    const [initialData, setInitialData] = useState<{ name: string; items: { name: string; quantity: number }[] } | null>(null);
    const [loading, setLoading] = useState(true);
    const [message, setMessage] = useState<{ type: "success" | "error"; text: string } | null>(null);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get("http://127.0.0.1:5556/one_liste", {
                    params: { id }
                });
                const data = response.data;

                setListName(data.name);
                setItems(typeof data.items === "string" ? JSON.parse(data.items) : data.items);
                setInitialData({
                    name: data.name,
                    items: typeof data.items === "string" ? JSON.parse(data.items) : data.items
                });
            } catch (error) {
                setMessage({ type: "error", text: "Erreur lors du chargement des données." });
            } finally {
                setLoading(false);
            }
        };

        fetchData();
    }, [id]);

    const isFormChanged = () => {
        if (!initialData) return false;
        return listName !== initialData.name || JSON.stringify(items) !== JSON.stringify(initialData.items);
    };

    const handleAddItem = () => {
        if (newItem.name && newItem.quantity > 0) {
            setItems([...items, newItem]);
            setNewItem({ name: "", quantity: 0 });
            setMessage(null);
        } else {
            setMessage({ type: "error", text: "Veuillez entrer un nom de produit et une quantité valide." });
        }
    };

    const handleRemoveItem = (index: number) => {
        setItems(items.filter((_, i) => i !== index));
    };

    const handleUpdate = async (e: React.FormEvent) => {
        e.preventDefault();

        if (!isFormChanged()) {
            setMessage({ type: "error", text: "Aucune modification détectée." });
            return;
        }

        try {
            const payload = {
                id: Number(id),
                name: listName,
                items
            };

            const response = await axios.put("http://127.0.0.1:5556/liste/update", payload, {
                headers: { "Content-Type": "application/json" }
            });

            if (response.status === 200) {
                setMessage({ type: "success", text: "Liste mise à jour avec succès !" });
                setInitialData({ name: listName, items });
            }
        } catch (error) {
            setMessage({ type: "error", text: "Erreur lors de la mise à jour." });
        }
    };

    if (loading) return <p>Chargement...</p>;

    return (
        <div className="space-y-4 p-4 max-w-6xl mx-auto">
            <div className="flex gap-4 items-center mb-10">
                <FontAwesomeIcon className="text-2xl" icon={faPenToSquare} />
                <h2 className="font-black text-2xl uppercase">Modifier la Liste</h2>
            </div>
            {message && <Message type={message.type} text={message.text} />}

            <form onSubmit={handleUpdate} className="space-y-4">
                <div>
                    <label className="block text-sm font-medium text-gray-700">Nom de la liste</label>
                    <input
                        type="text"
                        value={listName}
                        onChange={(e) => setListName(e.target.value)}
                        className="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                    />
                </div>
                <div>
                    <label className="block text-sm font-medium text-gray-700">Ajouter un élément</label>
                    <div className="flex space-x-2">
                        <input
                            type="text"
                            value={newItem.name}
                            onChange={(e) => setNewItem({ ...newItem, name: e.target.value })}
                            className="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                            placeholder="Nom du produit"
                        />
                        <input
                            type="number"
                            value={newItem.quantity}
                            onChange={(e) => setNewItem({ ...newItem, quantity: Number(e.target.value) })}
                            className="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                            placeholder="Quantité"
                        />
                        <button
                            type="button"
                            onClick={handleAddItem}
                            className="mt-1 px-4 py-2 bg-blue-500 text-white rounded-md"
                        >
                            Ajouter
                        </button>
                    </div>
                </div>
                <div className="space-y-2 flex gap-2 bg-gray-100 p-4 rounded-lg flex-wrap">
                    {items.map((item, index) => (
                        <div key={index} className="p-2 flex items-center bg-gray-200 font-bold rounded">
                            <span className="mr-2">{item.quantity} - {item.name}</span>
                            <button
                                type="button"
                                onClick={() => handleRemoveItem(index)}
                                className="text-red-500 ml-3 text-sm p-1 bg-gray-300 rounded"
                            >
                                <FontAwesomeIcon icon={faX} />
                            </button>
                        </div>
                    ))}
                </div>
                <div className={"flex gap-3"}>
                    <button type="submit" className="w-[80%] py-2 bg-green-500 text-white rounded-md">
                        Mettre à jour
                    </button>
                    <Link  className="w-[20%] py-2 bg-red-500 text-white rounded-md text-center" to={"/lists/all"}>
                     Quitter
                    </Link>
                </div>
            </form>
        </div>
    );
};

export default UpdateForm;
