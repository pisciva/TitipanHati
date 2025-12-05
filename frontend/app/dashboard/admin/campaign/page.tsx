// app/dashboard/admin/campaign/page.tsx
import Sidebar from "@/components/admin/sidebarAdmin/sidebar";
import Header from "@/components/admin/header/header";

export default function CampaignPage() {
  return (
    <div className="flex min-h-screen">
      <Sidebar />
      <main className="flex-1 p-10 bg-[#FAFAFA]">
        <Header />
        <h1 className="text-xl font-semibold mb-4">Manajemen Campaign</h1>
        <p className="text-gray-500">Belum ada data campaign untuk sekarang.</p>
      </main>
    </div>
  );
}
