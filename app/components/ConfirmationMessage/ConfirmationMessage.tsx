import React from "react";

export default function DeleteConfirmation({ onConfirm, onCancel }) {
    return (
        <div className="fixed inset-0 flex items-center justify-center bg-green-400 bg-opacity-8 ">
            <div className="bg-white bg-opacity-80 backdrop-blur-lg p-6 rounded-lg shadow-lg w-80 text-center border border-white ">
                <h2 className="text-lg font-semibold text-gray-800">
                    Êtes-vous sûr de vouloir supprimer cette liste ?
                </h2>
                <div className="mt-4 flex justify-around">
                    <button
                        className="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
                        onClick={onConfirm}
                    >
                        Oui
                    </button>
                    <button
                        className="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400"
                        onClick={onCancel}
                    >
                        Non
                    </button>
                </div>
            </div>
        </div>
    );
}
