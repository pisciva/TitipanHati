"use client";
import { Search } from "lucide-react";

export default function Header() {
  return (
    <div className="flex justify-between items-center mb-8">
      <div>
        <h1 className="text-2xl font-bold">Halo, Admin</h1>
        <p className="text-sm text-gray-500">
          Today is Saturday, 30 October 2025
        </p>
      </div>

      <div className="flex items-center gap-4">
        <div className="flex items-center bg-gray-100 px-3 py-2 rounded-xl">
          <Search className="w-4 h-4 text-gray-500 mr-2" />
          <input
            type="text"
            placeholder="Cari"
            className="bg-transparent outline-none text-sm"
          />
        </div>
        <button className="bg-black text-white px-4 py-2 rounded-xl text-sm">
          Tambah Campaign
        </button>
      </div>
    </div>
  );
}
