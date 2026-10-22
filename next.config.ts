import type { NextConfig } from "next";

const nextConfig: NextConfig = {
  // pg is a Node.js package, so keep it out of the bundle.
  serverExternalPackages: ["pg"],
};

export default nextConfig;
