FROM postgres:latest

# Create a symlink so older timezone name 'America/Buenos_Aires' resolves
RUN mkdir -p /usr/share/zoneinfo/America || true \
    && ln -sf /usr/share/zoneinfo/America/Argentina/Buenos_Aires /usr/share/zoneinfo/America/Buenos_Aires || true
