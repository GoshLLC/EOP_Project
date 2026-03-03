-- Add filter columns and indexes for animal search/filter (run after selecting your database in phpMyAdmin)
-- Compatible with existing animals table (id, name, species, breed, age, status, intake_date, image)

ALTER TABLE `animals`
  ADD COLUMN `location` VARCHAR(100) DEFAULT NULL AFTER `breed`,
  ADD COLUMN `sex` VARCHAR(20) DEFAULT NULL AFTER `age`,
  ADD COLUMN `fur_color` VARCHAR(50) DEFAULT NULL AFTER `sex`,
  ADD COLUMN `size` VARCHAR(20) DEFAULT NULL AFTER `fur_color`,
  ADD COLUMN `health_status` VARCHAR(50) DEFAULT NULL AFTER `size`;

-- Indexes for filter attributes (supports ~200 concurrent users and fast filter queries)
CREATE INDEX idx_animals_species ON animals (species);
CREATE INDEX idx_animals_location ON animals (location);
CREATE INDEX idx_animals_age ON animals (age);
CREATE INDEX idx_animals_sex ON animals (sex);
CREATE INDEX idx_animals_breed ON animals (breed);
CREATE INDEX idx_animals_fur_color ON animals (fur_color);
CREATE INDEX idx_animals_size ON animals (size);
CREATE INDEX idx_animals_health_status ON animals (health_status);
CREATE INDEX idx_animals_status ON animals (status);

-- Optional: backfill existing rows so filters work (adjust values as needed)
-- UPDATE animals SET location = 'Shelter A', sex = 'Unknown', size = 'Medium', health_status = 'Good' WHERE location IS NULL;
