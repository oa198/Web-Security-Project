<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Department;
use App\Models\Section;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseService
{
    /**
     * Get all courses with optional filtering and pagination.
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllCourses(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Course::query();
        
        // Apply filters
        if (isset($filters['department_id'])) {
            $query->where('department_id', $filters['department_id']);
        }
        
        if (isset($filters['semester']) && isset($filters['academic_year'])) {
            $query->whereHas('sections', function ($q) use ($filters) {
                $q->where('semester', $filters['semester'])
                  ->where('academic_year', $filters['academic_year']);
            });
        }
        
        if (isset($filters['instructor_id'])) {
            $query->whereHas('sections', function ($q) use ($filters) {
                $q->where('instructor_id', $filters['instructor_id']);
            });
        }
        
        if (isset($filters['level'])) {
            $query->where('level', $filters['level']);
        }
        
        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Only show active courses by default
        if (!isset($filters['show_inactive']) || !$filters['show_inactive']) {
            $query->where('is_active', true);
        }
        
        // Order by department and course code
        $query->orderBy('department_id')
              ->orderBy('code');
        
        return $query->with(['department', 'sections'])->paginate($perPage);
    }
    
    /**
     * Get a course by ID with its sections and department.
     *
     * @param int $courseId
     * @return Course
     */
    public function getCourseById(int $courseId): Course
    {
        return Course::with(['department', 'sections', 'prerequisites'])->findOrFail($courseId);
    }
    
    /**
     * Get all active departments.
     *
     * @return Collection
     */
    public function getAllDepartments(): Collection
    {
        return Department::orderBy('name')->get();
    }
    
    /**
     * Get all sections for a course.
     *
     * @param int $courseId
     * @param string|null $semester
     * @param string|null $academicYear
     * @return Collection
     */
    public function getCourseSections(int $courseId, ?string $semester = null, ?string $academicYear = null): Collection
    {
        $query = Section::where('course_id', $courseId);
        
        if ($semester && $academicYear) {
            $query->where('semester', $semester)
                  ->where('academic_year', $academicYear);
        }
        
        return $query->with(['instructor'])->get();
    }
    
    /**
     * Get course sections with available seats.
     *
     * @param int $courseId
     * @param string|null $semester
     * @param string|null $academicYear
     * @return Collection
     */
    public function getAvailableSections(int $courseId, ?string $semester = null, ?string $academicYear = null): Collection
    {
        $query = Section::where('course_id', $courseId)
                        ->where('is_full', false);
        
        if ($semester && $academicYear) {
            $query->where('semester', $semester)
                  ->where('academic_year', $academicYear);
        }
        
        return $query->with(['instructor'])->get();
    }
    
    /**
     * Check if a course has any sections with available seats.
     *
     * @param int $courseId
     * @param string|null $semester
     * @param string|null $academicYear
     * @return bool
     */
    public function courseHasAvailableSeats(int $courseId, ?string $semester = null, ?string $academicYear = null): bool
    {
        $query = Section::where('course_id', $courseId)
                        ->where('is_full', false);
        
        if ($semester && $academicYear) {
            $query->where('semester', $semester)
                  ->where('academic_year', $academicYear);
        }
        
        return $query->exists();
    }
    
    /**
     * Get the prerequisites for a course.
     *
     * @param int $courseId
     * @return Collection
     */
    public function getCoursePrerequisites(int $courseId): Collection
    {
        $course = Course::findOrFail($courseId);
        return $course->prerequisites;
    }
    
    /**
     * Create a new course.
     *
     * @param array $data
     * @return Course
     */
    public function createCourse(array $data): Course
    {
        return Course::create($data);
    }
    
    /**
     * Update an existing course.
     *
     * @param int $courseId
     * @param array $data
     * @return Course
     */
    public function updateCourse(int $courseId, array $data): Course
    {
        $course = Course::findOrFail($courseId);
        $course->update($data);
        
        if (isset($data['prerequisite_ids'])) {
            $course->prerequisites()->sync($data['prerequisite_ids']);
        }
        
        return $course;
    }
    
    /**
     * Delete a course.
     *
     * @param int $courseId
     * @return bool
     */
    public function deleteCourse(int $courseId): bool
    {
        $course = Course::findOrFail($courseId);
        return $course->delete();
    }
}
